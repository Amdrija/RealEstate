<?php

namespace Amdrija\RealEstate\Application\Interfaces;

interface IMicroLocationRepository
{
    public function getMicroLocations(string $cityId): array;
}