<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\MicroLocation;

class MicroLocationRepository extends Repository implements \Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository
{

    public function getMicroLocations(string $cityId): array
    {
        $query = "SELECT MicroLocation.id, MicroLocation.name, MicroLocation.municipalityId FROM realEstate.MicroLocation
    JOIN realEstate.Municipality M on M.id = MicroLocation.municipalityId";

        $parameters = [];
        if ($cityId != "") {
            $query .= " WHERE M.cityId = :cityId";
            $parameters['cityId'] = $cityId;
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute($parameters);
        $rows = $statement->fetchAll();

        $microLocations = [];
        foreach ($rows as $row) {
            $microLocation = new MicroLocation();
            $microLocation->id = $row['id'];
            $microLocation->name = $row['name'];
            $microLocation->municipalityId = $row['municipalityId'];
            $microLocations[] = $microLocation;
        }

        return $microLocations;
    }

    public function createMicroLocation(MicroLocation $microLocation): MicroLocation
    {
        return $this->insert($microLocation);
    }

    public function deleteMicroLocation(MicroLocation $microLocation)
    {
        return $this->delete($microLocation);
    }

    public function getMicroLocationById(string $id): ?MicroLocation
    {
        return $this->getById(MicroLocation::class, $id);
    }
}