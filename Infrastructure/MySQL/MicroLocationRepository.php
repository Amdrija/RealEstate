<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\MicroLocation;

class MicroLocationRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository
{

    public function getMicroLocations(string $cityId): array
    {
        $statement = $this->pdo->prepare("SELECT MicroLocation.id, MicroLocation.name FROM realEstate.MicroLocation
    JOIN realEstate.Municipality M on M.id = MicroLocation.municipalityId
    WHERE M.cityId = :cityId;");
        $statement->execute(['cityId' => $cityId]);
        $rows = $statement->fetchAll();

        $microLocations = [];
        foreach ($rows as $row) {
            $microLocation = new MicroLocation();
            $microLocation->id = $row['id'];
            $microLocation->name = $row['name'];
            $microLocations[] = $microLocation;
        }

        return $microLocations;
    }
}