<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository;
use Amdrija\RealEstate\Application\Interfaces\IMunicipalityRepository;
use Amdrija\RealEstate\Application\Models\MicroLocation;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\JSONResponse;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class MicroLocationController extends FrontController
{
    private readonly IMicroLocationRepository $microLocationRepository;
    private readonly IMunicipalityRepository $municipalityRepository;

    public function __construct(IMicroLocationRepository $microLocationRepository, IMunicipalityRepository $municipalityRepository)
    {
        parent::__construct();
        $this->microLocationRepository = $microLocationRepository;
        $this->municipalityRepository = $municipalityRepository;
    }

    public function getList(): Response
    {
        $microLocations = $this->microLocationRepository->getMicroLocations($this->request->getQueryParameters()['cityId']);

        return new JSONResponse($microLocations);
    }

    public function getMicroLocations(): Response
    {
        $municipalities = [] ;
        foreach ($this->municipalityRepository->getMunicipalities() as $municipality)
        {
            $municipalities[$municipality->id] = $municipality->name;
        }

        return $this->buildHtmlResponse("microLocations", ['title' => "MicroLocations",
            "microLocations" => $this->microLocationRepository->getMicroLocations(""),
            "municipalities" => $municipalities]);
    }

    public function createMicroLocationIndex(): Response
    {
        return $this->buildHtmlResponse("addMicroLocation", ['title' => 'Add micro location',
            "municipalities" => $this->municipalityRepository->getMunicipalities()]);
    }

    public function createMicroLocation(): Response
    {
        $microLocation = new MicroLocation();
        $microLocation->name = $this->request->getBodyParameter('name');
        $microLocation->municipalityId = $this->request->getBodyParameter('municipalityId');

        $this->microLocationRepository->createMicroLocation($microLocation);

        return new RedirectResponse("/admin/microLocations");
    }

    public function deleteMicroLocation(array $parameters): Response
    {
        if(!isset($parameters['id'])) {
            return ErrorResponseFactory::getResponse('Id not set.', 400);
        }

        $microLocation = $this->microLocationRepository->getMicroLocationById($parameters['id']);

        if (is_null($microLocation)) {
            return new RedirectResponse("/admin/microLocations");
        }

        try {
            $this->microLocationRepository->deleteMicroLocation($microLocation);
        } catch(\Exception) {
            return new RedirectResponse("/admin/microLocations");
        }

        return new RedirectResponse("/admin/microLocations");
    }
}