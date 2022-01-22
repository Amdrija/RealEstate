<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IAgencyRepository;
use Amdrija\RealEstate\Application\Models\Agency;

class AgencyRepository extends Repository implements IAgencyRepository
{

    public function getAgencies(): array
    {
        return parent::getList(Agency::class);
    }
}