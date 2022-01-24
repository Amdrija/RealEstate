<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\Perk;

class PerkRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IPerkRepository
{

    public function getPerks(): array
    {
        return parent::getList(Perk::class);
    }
}