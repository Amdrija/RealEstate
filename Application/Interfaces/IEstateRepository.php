<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;

interface IEstateRepository
{
    public function createEstate(AddEstate $estate, array $images, string $id, string $advertiserId): Estate;
}