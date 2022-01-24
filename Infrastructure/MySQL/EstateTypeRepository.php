<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IEstateTypeRepository;
use Amdrija\RealEstate\Application\Models\EstateType;

class EstateTypeRepository extends Repository implements IEstateTypeRepository
{
    public function getEstateTypes(): array
    {
        return parent::getList(EstateType::class);
    }
}