<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\ConditionType;

class ConditionTypeRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository
{
    public function getConditionTypes(): array
    {
        return parent::getList(ConditionType::class);
    }
}