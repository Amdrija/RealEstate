<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Interfaces\IEstateTypeRepository;
use Amdrija\RealEstate\Application\Services\EstateService;
use Amdrija\RealEstate\Framework\Responses\Response;

class HomeController extends FrontController
{
    private readonly EstateService $estateService;
    private readonly IEstateTypeRepository $estateTypeRepository;
    private readonly ICityRepository $cityRepository;

    public function __construct(EstateService $estateService, IEstateTypeRepository $estateTypeRepository, ICityRepository $cityRepository)
    {
        $this->estateService = $estateService;
        $this->estateTypeRepository = $estateTypeRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index(): Response
    {
        return $this->buildHtmlResponse('landingPage', ['title' => 'Estate',
            'estates' => $this->estateService->getLatest(),
            'estateTypes' => $this->estateTypeRepository->getEstateTypes(),
            'cities' => $this->cityRepository->getCities()]);
    }
}