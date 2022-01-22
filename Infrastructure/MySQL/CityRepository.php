<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Models\City;

class CityRepository extends Repository implements ICityRepository
{

    public function getCities(): array
    {
        return parent::getList(City::class);
    }
}