<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\Street;
use Illuminate\Support\Str;

interface IStreetRepository
{
    public function getStreets(): array;

    public function createStreet(Street $street): Street;

    public function deleteStreet(Street $street);

    public function getStreetById(string $id): ?Street;
}