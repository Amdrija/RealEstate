<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\Agency;

interface IAgencyRepository
{
    public function getAgencies(): array;

    public function createAgency(Agency $agency): Agency;

    public function deleteAgency(Agency $agency);

    public function getAgencyById(string $id): ?Agency;
}