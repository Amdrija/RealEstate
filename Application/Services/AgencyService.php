<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Interfaces\IAgencyRepository;

class AgencyService
{
    private readonly IAgencyRepository $agencyRepository;

    public function __construct(IAgencyRepository $agencyRepository)
    {
        $this->agencyRepository = $agencyRepository;
    }

    public function getAgenciesForSelect(): array
    {
        return $this->agencyRepository->getAgencies();
    }
}