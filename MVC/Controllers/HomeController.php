<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Services\EstateService;
use Amdrija\RealEstate\Framework\Responses\Response;

class HomeController extends FrontController
{
    private readonly EstateService $estateService;

    public function __construct(EstateService $estateService)
    {
        $this->estateService = $estateService;
    }

    public function index(): Response
    {
        return $this->buildHtmlResponse('landingPage', ['title' => 'Estate', 'estates' => $this->estateService->getLatest()]);
    }
}