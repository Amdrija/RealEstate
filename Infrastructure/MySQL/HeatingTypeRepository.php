<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\HeatingType;

class HeatingTypeRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IHeatingTypeRepository
{
    public function getHeatingTypes(): array
    {
        return parent::getList(HeatingType::class);
    }
}