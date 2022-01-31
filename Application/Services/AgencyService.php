<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Exceptions\Agency\AgencyNotFoundException;
use Amdrija\RealEstate\Application\Interfaces\IAgencyRepository;
use Amdrija\RealEstate\Application\Models\Agency;
use Amdrija\RealEstate\Application\RequestModels\Agency\AddAgency;

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

    public function createAgency(AddAgency $addAgency): Agency
    {
        $agency = new Agency($addAgency->name, $addAgency->pib, $addAgency->streetId, $addAgency->streetNumber);
        return $this->agencyRepository->createAgency($agency);
    }

    /**
     * @throws AgencyNotFoundException
     */
    public function deleteAgency(string $id)
    {
        $agency = $this->agencyRepository->getAgencyById($id);

        if (is_null($agency)) {
            throw new AgencyNotFoundException();
        }

        $this->agencyRepository->deleteAgency($agency);
    }
}