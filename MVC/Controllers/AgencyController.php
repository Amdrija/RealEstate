<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\IStreetRepository;
use Amdrija\RealEstate\Application\RequestModels\Agency\AddAgency;
use Amdrija\RealEstate\Application\Services\AgencyService;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class AgencyController extends FrontController
{
    private readonly AgencyService $agencyService;
    private readonly IStreetRepository $streetRepository;

    public function __construct(AgencyService $agencyService, IStreetRepository $streetRepository)
    {
        parent::__construct();
        $this->agencyService = $agencyService;
        $this->streetRepository = $streetRepository;
    }

    public function getAgencies(): Response
    {
        $streets = [];
        foreach ($this->streetRepository->getStreets() as $street) {
            $streets[$street->id] = $street->name;
        }
        return $this->buildHtmlResponse("agencies", ['title' => 'Agencies',
            'agencies' => $this->agencyService->getAgenciesForSelect(),
            'streets' => $streets
        ]);
    }

    public function createAgencyIndex(): Response
    {
        return $this->buildHtmlResponse('addAgency', ['title' => 'Add agency',
            'streets' => $this->streetRepository->getStreets()]);
    }

    public function createAgency(): Response
    {
        try{
            $this->agencyService->createAgency($this->request->deseralizeBody(AddAgency::class));
        } catch (\Exception $exception) {
            return ErrorResponseFactory::getResponse($exception->getMessage(), 400);
        }

        return new RedirectResponse("/admin/agencies");
    }

    public function deleteAgency(array $parameters): Response
    {
        if(!isset($parameters['id'])) {
            return ErrorResponseFactory::getResponse('Id not set.', 400);
        }

        try{
            $this->agencyService->deleteAgency($parameters['id']);
        } catch (\Exception $exception) {
            return ErrorResponseFactory::getResponse($exception->getMessage(), 400);
        }

        return new RedirectResponse("/admin/agencies");
    }
}