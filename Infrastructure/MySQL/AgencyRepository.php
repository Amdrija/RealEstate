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

    public function createAgency(Agency $agency): Agency
    {
        return $this->insert($agency);
    }

    public function deleteAgency(Agency $agency)
    {
        $this->delete($agency);
    }

    public function getAgencyById(string $id): ?Agency
    {
        return $this->getById(Agency::class, $id);
    }
}