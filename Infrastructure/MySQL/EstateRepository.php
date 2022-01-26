<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IEstateRepository;
use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\Models\Perk;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForSearchResult;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSummary;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Exception;

class EstateRepository extends Repository implements IEstateRepository
{

    public function createEstate(AddEstate $estate, array $images, string $id, string $advertiserId): Estate
    {
        try {
            $this->pdo->beginTransaction();
            $statementEstate = $this->pdo->prepare("INSERT INTO realEstate.Estate(
                          id,
                          price,
                          surface,
                          numberOfRooms,
                          typeId,
                          constructionDate,
                          conditionId,
                          heatingId,
                          floor,
                          totalFloors,
                          description,
                          advertiserId,
                          streetId,
                          streetNumber,
                          busLines,
                          images,
                          name
                ) VALUES(
                          :id,
                          :price,
                          :surface,
                          :numberOfRooms,
                          :typeId,
                          :constructionDate,
                          :conditionId,
                          :heatingId,
                          :floor,
                          :totalFloors,
                          :description,
                          :advertiserId,
                          :streetId,
                          :streetNumber,
                          :busLines,
                          :images,
                          :name
            )");
            $statementEstate->execute([
                'id' => $id,
                'price' => $estate->price,
                'surface' => $estate->surface,
                'numberOfRooms' => $estate->numberOfRooms,
                'typeId' => $estate->typeId,
                'constructionDate' => $estate->constructionDate->format("Y-m-d"),
                'conditionId' => $estate->conditionId,
                'heatingId' => $estate->heatingId,
                'floor' => $estate->floor,
                'totalFloors' => $estate->totalFloors,
                'description' => $estate->description,
                'advertiserId' => $advertiserId,
                'streetId' => $estate->streetId,
                'streetNumber' => $estate->streetNumber,
                'busLines' => join(", ", $estate->busLines),
                'images' => join(", ", $images),
                'name' => $estate->name
            ]);

            /* @var $perk Perk*/
            foreach ($estate->perks as $perk) {
                $statementPerk = $this->pdo->prepare("INSERT INTO realEstate.EstatePerk(perkId, estateId) VALUES (:perkId, :estateId)");
                $statementPerk->execute(['perkId' => $perk, 'estateId' => $id]);
            }

            $this->pdo->commit();
        } catch (Exception $e) {
            $this->pdo->rollback();
            throw $e;
        }

        /* TODO: Change return*/
        return new Estate();
    }

    public function getLatest(int $count): array
    {
        $estates = [];
        foreach($this->pdo->query("SELECT id, name, price, surface, busLines, images, numberOfRooms 
            FROM realEstate.Estate 
            ORDER BY dateAdded DESC 
            LIMIT $count")->fetchAll() as $row)
        {
            $estates []= new EstateSummary($row['id'], $row['name'], $row['price'], $row['surface'], $row['busLines'], $row['images'], $row['numberOfRooms']);
        }

        return $estates;
    }

    public function countEstates(SearchEstate $estate): int
    {
        $query = "SELECT COUNT(*) ";
        $query .= $this->getQueryPartForSearch($estate);
        $statement = $this->pdo->prepare($query);
        $queryParameters = $estate->convertToArray();
        $statement->execute($queryParameters);

        return $statement->fetchColumn();
    }

    public function searchEstates(SearchEstate $estate, int $limit, int $offset): array
    {
        $query = "SELECT E.id, E.name, C.name as cityName, M.name as municipalityName, ML.name as microLocationName, E.surface, E.numberOfRooms, E.floor, E.description, E.price, ML.id as microLocationId, E.images";

        $query .= " " . $this->getQueryPartForSearch($estate);
        $query .= "\nLIMIT $limit";
        $queryParameters = $estate->convertToArray();
        if ($offset > 0) {
            $query .= " OFFSET  $offset";
        }

        $statement = $this->pdo->prepare($query);

        $statement->execute($queryParameters);
        $rows = $statement->fetchAll();
        $averagePriceByMicroLocation = $this->getAveragePriceByMicroLocation();

        $results = [];
        foreach ($rows as $row) {
            $results []= new EstateForSearchResult(
                $row['id'],
                $row['name'],
                $row['cityName'],
                $row['municipalityName'],
                $row['microLocationName'],
                $row['surface'],
                $row['numberOfRooms'],
                $row['floor'],
                $row['description'],
                $row['price'],
                $averagePriceByMicroLocation[$row['microLocationId']],
                $row['images']
            );
        }

        return $results;
    }

    public function getAveragePriceByMicroLocation(): array {
        $rows = $this->pdo->query("SELECT S.microLocationId, AVG(E.price / E.surface) as averagePrice FROM realEstate.Estate E
            JOIN realEstate.Street S on S.id = E.streetId
            GROUP BY S.microLocationId;")->fetchAll();

        $priceByMicroLocation = [];
        foreach ($rows as $row) {
            $priceByMunicipality[$row['microLocationId']] = $row['averagePrice'];
        }

        return $priceByMunicipality;
    }

    private function getQueryPartForSearch(SearchEstate $estate): string
    {
        $query = "FROM realEstate.Estate E
            JOIN realEstate.Street S on E.streetId = S.id
            JOIN realEstate.MicroLocation ML on ML.id = S.microLocationId
            JOIN realEstate.Municipality M on ML.municipalityId = M.id
            JOIN realEstate.City C on M.cityId = C.id
            WHERE  E.price >= :priceFrom AND E.price <= :priceUpTo
                AND E.surface >= :surfaceFrom AND E.surface <= :surfaceUpTo
                AND E.numberOfRooms >= :roomsFrom AND E.numberOfRooms <= :roomsUpTo
                AND YEAR(E.constructionDate) >= :yearFrom AND YEAR(E.constructionDate) <= :yearUpTo
                AND E.floor >= :floorFrom AND E.floor <= :floorUpTo";

        if (!is_null($estate->conditionId)) {
            $query .= " AND E.conditionId = :conditionId";
        }

        if (!is_null($estate->typeId)) {
            $query .= " AND E.typeId= :typeId";
        }

        if (!is_null($estate->cityId)) {
            $query .= " AND C.id = :cityId";
        }

        if (!is_null($estate->microLocationIds)) {
            $query .= " AND ML.id IN (:microLocationIds)";
        }

        return $query;
    }
}