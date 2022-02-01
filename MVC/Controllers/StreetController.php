<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository;
use Amdrija\RealEstate\Application\Interfaces\IStreetRepository;
use Amdrija\RealEstate\Application\Models\Street;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class StreetController extends FrontController
{
    private readonly IStreetRepository $streetRepository;
    private readonly IMicroLocationRepository $microLocationRepository;

    public function __construct(IStreetRepository $streetRepository, IMicroLocationRepository $microLocationRepository)
    {
        parent::__construct();
        $this->streetRepository = $streetRepository;
        $this->microLocationRepository = $microLocationRepository;
    }

    public function getStreets():Response
    {
        $microLocations = [];
        foreach ($this->microLocationRepository->getMicroLocations("") as $microLocation) {
            $microLocations[$microLocation->id] = $microLocation->name;
        }

        return $this->buildHtmlResponse('streets', ['title' => 'Streets',
            'streets' => $this->streetRepository->getStreets(),
            'microLocations' => $microLocations]);
    }

    public function createStreetIndex(): Response
    {
        return $this->buildHtmlResponse('addStreet', ['title' => 'Add Street',
            'microLocations' => $this->microLocationRepository->getMicroLocations("")]);
    }

    public function createStreet(): Response
    {
        $street = new Street();
        $street->name = $this->request->getBodyParameter("name");
        $street->microLocationId = $this->request->getBodyParameter("microLocationId");

        $this->streetRepository->createStreet($street);
        return new RedirectResponse("/admin/streets");
    }

    public function deleteStreet(array $parameters): Response
    {
        if(!isset($parameters['id'])) {
            return ErrorResponseFactory::getResponse('Id not set.', 400);
        }

        $street = $this->streetRepository->getStreetById($parameters['id']);

        if (is_null($street)) {
            return new RedirectResponse("/admin/streets");
        }

        try {
            $this->streetRepository->deleteStreet($street);
        } catch(\Exception) {
            return new RedirectResponse("/admin/microLocations");
        }

        return new RedirectResponse("/admin/microLocations");
    }
}