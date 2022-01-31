<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\IBusLineRepository;
use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IEstateTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IHeatingTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IPerkRepository;
use Amdrija\RealEstate\Application\Interfaces\IStreetRepository;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Amdrija\RealEstate\Application\Services\EstateService;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Framework\ImageService;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class EstateController extends FrontController
{
    private readonly EstateService $estateService;
    private readonly ImageService $imageService;
    private readonly IBusLineRepository $busLineRepository;
    private readonly IConditionTypeRepository $conditionTypeRepository;
    private readonly IEstateTypeRepository $estateTypeRepository;
    private readonly IHeatingTypeRepository $heatingTypeRepository;
    private readonly IStreetRepository $streetRepository;
    private readonly IPerkRepository $perkRepository;
    private readonly LoginService $loginService;
    private readonly ICityRepository $cityRepository;

    public function __construct(EstateService            $estateService,
                                ImageService             $imageService,
                                IBusLineRepository       $busLineRepository,
                                IConditionTypeRepository $conditionTypeRepository,
                                IEstateTypeRepository    $estateTypeRepository,
                                IHeatingTypeRepository   $heatingTypeRepository,
                                IStreetRepository        $streetRepository,
                                IPerkRepository          $perkRepository,
                                LoginService             $loginService,
                                ICityRepository          $cityRepository)
    {
        parent::__construct();
        $this->estateService = $estateService;
        $this->imageService = $imageService;
        $this->busLineRepository = $busLineRepository;
        $this->conditionTypeRepository = $conditionTypeRepository;
        $this->estateTypeRepository = $estateTypeRepository;
        $this->heatingTypeRepository = $heatingTypeRepository;
        $this->streetRepository = $streetRepository;
        $this->perkRepository = $perkRepository;
        $this->loginService = $loginService;
        $this->cityRepository = $cityRepository;
    }

    public function searchByUser(): Response
    {
        $user = $this->loginService->getCurrentUser();
        $searchEstate = new SearchEstate($this->request->getQueryParameters());

        return $this->buildHtmlResponse('searchEstatesByUser', ['title' => 'Estate',
            'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
            'cities' => $this->cityRepository->getCities(),
            'conditionTypes' => $this->conditionTypeRepository->getConditionTypes(),
            'paginatedResponse' => $this->estateService->searchEstatesByUserId($searchEstate, $this->request->getQueryParameters(), $user->id),
            'searchEstate' => $searchEstate]);
    }

    public function addEstateIndex(): Response
    {
        return $this->buildHtmlResponse('addEstate',
            [
                'title' => 'Add Estate',
                'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
                'conditionTypes' => $this->conditionTypeRepository->getConditionTypes(),
                'heatingTypes' => $this->heatingTypeRepository->getHeatingTypes(),
                'streets' => $this->streetRepository->getStreets(),
                'busLines' => $this->busLineRepository->getBusLines(),
                'perks' => $this->perkRepository->getPerks()
            ]);
    }

    public function addEstate(): Response
    {
        if (!isset($this->request->getFiles()['images'])) {
            $error = "Please add images";
        }

        if (!isset($this->request->getBody()['perks'])) {
            $error = "Perks need to be an array";
        }

        if (!isset($this->request->getFiles()['busLines'])) {
            $error = "Bus lines need to be an array";
        }

        if (isset($error)) {
            $this->buildHtmlResponse('addEstate',
                [
                    'title' => 'Add Estate',
                    'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
                    'conditionTypes' => $this->conditionTypeRepository->getConditionTypes(),
                    'heatingTypes' => $this->heatingTypeRepository->getHeatingTypes(),
                    'streets' => $this->streetRepository->getStreets(),
                    'busLines' => $this->busLineRepository->getBusLines(),
                    'perks' => $this->perkRepository->getPerks(),
                    'error' => $error
                ]);
        }
        /* @var $estate AddEstate */
        $estate = $this->request->deseralizeBody(AddEstate::class);

        $user = $this->loginService->getCurrentUser();
        if (is_null($user)) {
            return ErrorResponseFactory::getResponse("Unauthorized", 403);
        }

        $estate->perks = array_slice($estate->perks, 1);

        $this->estateService->createEstate($estate,
            $this->request->getFilesByParameter('images'),
            $user);

        return new RedirectResponse("/");
    }

    public function editEstateIndex(array $parameters): Response
    {
        if(!isset($parameters['id'])) {
            return ErrorResponseFactory::getResponse('Id not set.', 400);
        }

        $estate = $this->estateService->getEstateForEdit($parameters['id'], $this->loginService->getCurrentUser());
        if (is_null($estate)) {
            return ErrorResponseFactory::getResponse("Estate not found.", 404);
        }

        return $this->buildHtmlResponse('editEstate',[
            'title' => 'Edit Estate',
            'estate' => $estate,
            'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
            'conditionTypes' => $this->conditionTypeRepository->getConditionTypes(),
            'heatingTypes' => $this->heatingTypeRepository->getHeatingTypes(),
            'streets' => $this->streetRepository->getStreets(),
            'busLines' => $this->busLineRepository->getBusLines(),
            'perks' => $this->perkRepository->getPerks(),
        ]);
    }

    public function editEstate(array $parameters): Response
    {
        if(!isset($parameters['id'])) {
            return ErrorResponseFactory::getResponse('Id not set.', 400);
        }

        if (!isset($this->request->getFiles()['images'])) {
            $error = "Please add images";
        }

        if (!isset($this->request->getBody()['perks'])) {
            $error = "Perks need to be an array";
        }

        if (!isset($this->request->getFiles()['busLines'])) {
            $error = "Bus lines need to be an array";
        }

        if (isset($error)) {
            $this->buildHtmlResponse('editEstate',
                [
                    'title' => 'Edit Estate',
                    'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
                    'conditionTypes' => $this->conditionTypeRepository->getConditionTypes(),
                    'heatingTypes' => $this->heatingTypeRepository->getHeatingTypes(),
                    'streets' => $this->streetRepository->getStreets(),
                    'busLines' => $this->busLineRepository->getBusLines(),
                    'perks' => $this->perkRepository->getPerks(),
                    'error' => $error
                ]);
        }
        /* @var $estate AddEstate */
        $estate = $this->request->deseralizeBody(AddEstate::class);

        $user = $this->loginService->getCurrentUser();
        if (is_null($user)) {
            return ErrorResponseFactory::getResponse("Unauthorized", 403);
        }

        $estate->perks = array_slice($estate->perks, 1);

        $this->estateService->editEstate($estate,
            $this->request->getFilesByParameter('images'),
            $parameters['id'],
            $user);

        return new RedirectResponse("/estates/edit/{$parameters['id']}");
    }
}