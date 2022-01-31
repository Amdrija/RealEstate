<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IEstateTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IPerkRepository;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Amdrija\RealEstate\Application\Services\EstateService;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\Response;

class HomeController extends FrontController
{
    private readonly EstateService $estateService;
    private readonly IEstateTypeRepository $estateTypeRepository;
    private readonly ICityRepository $cityRepository;
    private readonly IConditionTypeRepository $conditionTypeRepository;
    private readonly IPerkRepository $perkRepository;
    private readonly LoginService $loginService;

    public function __construct(EstateService $estateService, IEstateTypeRepository $estateTypeRepository, ICityRepository $cityRepository, \Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository $conditionTypeRepository, \Amdrija\RealEstate\Application\Interfaces\IPerkRepository $perkRepository, \Amdrija\RealEstate\Application\Services\LoginService $loginService)
    {
        parent::__construct();
        $this->estateService = $estateService;
        $this->estateTypeRepository = $estateTypeRepository;
        $this->cityRepository = $cityRepository;
        $this->conditionTypeRepository = $conditionTypeRepository;
        $this->perkRepository = $perkRepository;
        $this->loginService = $loginService;
    }

    public function index(): Response
    {
        return $this->buildHtmlResponse('landingPage', ['title' => 'Estate',
            'estates' => $this->estateService->getLatest(),
            'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
            'cities' => $this->cityRepository->getCities()]);
    }

    public function search(): Response
    {
        $searchEstate = new SearchEstate($this->request->getQueryParameters());

        return $this->buildHtmlResponse('searchEstates', ['title' => 'Estate',
            'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
            'cities' => $this->cityRepository->getCities(),
            'conditionTypes' => $this->conditionTypeRepository->getConditionTypes(),
            'paginatedResponse' => $this->estateService->searchEstates($searchEstate, $this->request->getQueryParameters()),
            'searchEstate' => $searchEstate]);
    }

    public function getEstateById(array $parameters): Response
    {
        if(!isset($parameters['id'])) {
            return ErrorResponseFactory::getResponse('Id not set.', 400);
        }

        $estate = $this->estateService->getEstateSingle($parameters['id'], $this->loginService->getCurrentUser());
        if(is_null($estate)) {
            return ErrorResponseFactory::getResponse('Estate not found', 404);
        }

        return $this->buildHtmlResponse('estate', [
            'title' => 'Estate',
            'estate' => $estate,
            'perks' => $this->perkRepository->getPerks()]);
    }
}