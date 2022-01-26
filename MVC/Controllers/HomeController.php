<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IEstateTypeRepository;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Amdrija\RealEstate\Application\Services\EstateService;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Amdrija\RealEstate\Framework\Responses\Response;

class HomeController extends FrontController
{
    private readonly EstateService $estateService;
    private readonly IEstateTypeRepository $estateTypeRepository;
    private readonly ICityRepository $cityRepository;
    private readonly IConditionTypeRepository $conditionTypeRepository;

    public function __construct(EstateService $estateService, IEstateTypeRepository $estateTypeRepository, ICityRepository $cityRepository, \Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository $conditionTypeRepository)
    {
        parent::__construct();
        $this->estateService = $estateService;
        $this->estateTypeRepository = $estateTypeRepository;
        $this->cityRepository = $cityRepository;
        $this->conditionTypeRepository = $conditionTypeRepository;
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
}