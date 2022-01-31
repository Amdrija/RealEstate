<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IMunicipalityRepository;
use Amdrija\RealEstate\Application\Models\Municipality;

class MunicipalityRepository extends Repository implements IMunicipalityRepository
{

    public function getMunicipalities(): array
    {
        return $this->getList(Municipality::class);
    }
}