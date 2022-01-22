<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\RequestModels\City\CitySelect;

class CityService
{
    private readonly ICityRepository $cityRepository;

    public function __construct(ICityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function getCitiesForSelect(): array
    {
        return $this->cityRepository->getCities();
    }
}