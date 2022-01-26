<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\JSONResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class MicroLocationController extends FrontController
{
    private readonly IMicroLocationRepository $microLocationRepository;

    public function __construct(IMicroLocationRepository $microLocationRepository)
    {
        parent::__construct();
        $this->microLocationRepository = $microLocationRepository;
    }

    public function getList(): Response
    {
        if (!isset($this->request->getQueryParameters()['cityId']))
        {
            return ErrorResponseFactory::getResponse('CityId not set.', 400);
        }

        $microLocations = $this->microLocationRepository->getMicroLocations($this->request->getQueryParameters()['cityId']);

        return new JSONResponse($microLocations);
    }
}