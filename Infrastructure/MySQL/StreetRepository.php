<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\Street;

class StreetRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IStreetRepository
{
    public function getStreets(): array
    {
        return parent::getList(Street::class);
    }
}