<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository;
use Amdrija\RealEstate\Application\Interfaces\IStatsRepository;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\JSONResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class StatsController extends FrontController
{
    private readonly IStatsRepository $statsRepository;
    private readonly LoginService $loginService;
    private readonly IMicroLocationRepository $microLocationRepository;

    public function __construct(IStatsRepository $statsRepository, LoginService $loginService, IMicroLocationRepository $microLocationRepository)
    {
        parent::__construct();
        $this->statsRepository = $statsRepository;
        $this->loginService = $loginService;
        $this->microLocationRepository = $microLocationRepository;
    }

    public function getStats(): Response
    {
        $user = $this->loginService->getCurrentUser();

        if (is_null($user->agencyId)) {
            if (!isset($this->request->getQueryParameters()['microLocationId'])) {
                return ErrorResponseFactory::getResponse("Set micro location id", 400);
            }

            $stats = $this->statsRepository->getStatsByMicroLocation($this->request->getQueryParameters()['microLocationId']);

        } else {
            $stats = $this->statsRepository->getStatsByAgency($user->agencyId);
        }

        $statsArray['labels'] = $stats->labels;
        $statsArray['values'] = $stats->values;

        return new JSONResponse($statsArray);
    }

    public function getStatsIndex(): Response
    {
        $user = $this->loginService->getCurrentUser();

        if (is_null($user->agencyId)) {
            if (!isset($this->request->getQueryParameters()['microLocationId'])) {
                return $this->buildHtmlResponse("charts", ['title' => 'Charts',
                    'error' => 'Please choose micro location',
                    'user' => $user,
                    'microLocations' => $this->microLocationRepository->getMicroLocations("")]);
            }

            $stats = $this->statsRepository->getStatsByMicroLocation($this->request->getQueryParameters()['microLocationId']);

        } else {
            $stats = $this->statsRepository->getStatsByAgency($user->agencyId);
        }

        return $this->buildHtmlResponse("charts", ['title' => 'Charts',
            'stats' => $stats,
            'user' => $user,
            'microLocations' => $this->microLocationRepository->getMicroLocations("")]);
    }
}