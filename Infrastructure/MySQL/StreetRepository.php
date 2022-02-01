<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\Street;

class StreetRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IStreetRepository
{
    public function getStreets(): array
    {
        return parent::getList(Street::class);
    }

    public function createStreet(Street $street): Street
    {
        return $this->insert($street);
    }

    public function deleteStreet(Street $street)
    {
        return $this->delete($street);
    }

    public function getStreetById(string $id): ?Street
    {
        return $this->getById(Street::class, $id);
    }
}