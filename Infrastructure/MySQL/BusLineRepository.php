<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\BusLine;

class BusLineRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IBusLineRepository
{

    public function getBusLines(): array
    {
        return parent::getList(BusLine::class);
    }
}