<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\MicroLocation;

interface IMicroLocationRepository
{
    public function getMicroLocations(string $cityId): array;

    public function createMicroLocation(MicroLocation $microLocation): MicroLocation;

    public function deleteMicroLocation(MicroLocation $microLocation);

    public function getMicroLocationById(string $id): ?MicroLocation;
}