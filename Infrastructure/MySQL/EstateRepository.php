<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IEstateRepository;
use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\Models\Perk;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForEditing;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForSearchResult;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSingle;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSummary;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Amdrija\RealEstate\Application\RequestModels\User\UserForEstate;
use Amdrija\RealEstate\Framework\ArraySerializer;
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

    public function editEstate(AddEstate $estate, array $images, string $id): Estate
    {
        try {
            $this->pdo->beginTransaction();
            $statementEstate = $this->pdo->prepare("UPDATE realEstate.Estate SET 
                          price = :price,
                          surface = :surface,
                          numberOfRooms = :numberOfRooms,
                          typeId = :typeId,
                          constructionDate = :constructionDate,
                          conditionId = :conditionId,
                          heatingId = :heatingId,
                          floor = :floor,
                          totalFloors = :totalFloors,
                          description = :description,
                          streetId = :streetId,
                          streetNumber = :streetNumber,
                          busLines = :busLines,
                          images = :images,
                          name = :name WHERE id = :id");

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
                'streetId' => $estate->streetId,
                'streetNumber' => $estate->streetNumber,
                'busLines' => join(", ", $estate->busLines),
                'images' => join(", ", $images),
                'name' => $estate->name
            ]);

            $deletePerksStatement = $this->pdo->prepare("DELETE FROM realEstate.EstatePerk WHERE estateId = :id");
            $deletePerksStatement->execute(['id' => $id]);

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
            WHERE sold = false
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
        $query .= " AND E.sold = false";
        $statement = $this->pdo->prepare($query);
        $queryParameters = $estate->convertToArray();
        $statement->execute($queryParameters);

        return $statement->fetchColumn();
    }

    public function searchEstates(SearchEstate $estate, int $limit, int $offset): array
    {
        $query = "SELECT E.id, E.name, C.name as cityName, M.name as municipalityName, ML.name as microLocationName, E.surface, E.numberOfRooms, E.floor, E.description, E.price, ML.id as microLocationId, E.images";

        $query .= " " . $this->getQueryPartForSearch($estate);
        $query .= " AND E.sold = false";
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
                $row['images'],
                false
            );
        }

        return $results;
    }

    public function getAveragePriceByMicroLocation(): array {
        $rows = $this->pdo->query("SELECT S.microLocationId, AVG(E.price / E.surface) as averagePrice FROM realEstate.Estate E
            JOIN realEstate.Street S on S.id = E.streetId
            WHERE E.sold = false
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

    public function getSingleEstateById(string $id, ?User $user): ?EstateSingle
    {
        $statementEstate = $this->pdo->prepare("SELECT E.*, CT.name as 'condition', ET.name as 'type', 
               HT.name as 'heating', S.name as street, ML.name as microLocation,
               M.name  as 'municipality', C.name as 'city', ML.id as microLocationId
            FROM realEstate.Estate E
            JOIN realEstate.ConditionType CT on E.conditionId = CT.id
            JOIN realEstate.EstateType ET on ET.id = E.typeId
            JOIN realEstate.HeatingType HT on E.heatingId = HT.id
            JOIN realEstate.Street S on E.streetId = S.id
            JOIN realEstate.MicroLocation ML on S.microLocationId = ML.id
            JOIN realEstate.Municipality M on ML.municipalityId = M.id
            JOIN realEstate.City C on M.cityId = C.id
            WHERE E.id = :id AND E.sold = false");
        $statementEstate->execute(['id' => $id]);
        $rowEstate = $statementEstate->fetch();

        if (is_null($rowEstate)) {
            return null;
        }

        $statementPerks = $this->pdo->prepare("SELECT P.id FROM realEstate.Perk P
            JOIN realEstate.EstatePerk EP on P.id = EP.perkId
            where EP.estateId = :id;");
        $statementPerks->execute(['id' => $id]);
        $rowPerks = $statementPerks->fetchAll();

        $statementAverage = $this->pdo->prepare("SELECT AVG(E.price / E.surface) FROM realEstate.Estate E
            JOIN realEstate.Street S on S.id = E.streetId
            JOIN realEstate.MicroLocation ML on ML.id = S.microLocationId
            WHERE ML.id = :microLocationId
            GROUP BY ML.id;");
        $statementAverage->execute(['microLocationId' => $rowEstate['microLocationId']]);
        $averagePrice = $statementAverage->fetchColumn();

        $advertiserStatement = $this->pdo->prepare("
            SELECT U.firstName, U.lastName, U.telephone, U.agencyId, U.licenceNumber
            FROM realEstate.User U
            WHERE U.id = :id;");
        $advertiserStatement->execute(['id' => $rowEstate['advertiserId']]);
        $advertiser = $advertiserStatement->fetch();

        $agency = null;
        if (!is_null($advertiser['agencyId'])) {
            $agencyStatement = $this->pdo->prepare("
                SELECT A.name, A.pib , S.name as street, A.number, C.name as city
                FROM realEstate.Agency A
                JOIN realEstate.Street S on S.id = A.streetId
                JOIN realEstate.MicroLocation ML on ML.id = S.microLocationId
                JOIN realEstate.Municipality M on M.id = ML.municipalityId
                JOIN realEstate.City C on C.id = M.cityId
                WHERE A.id = :id;");
            $agencyStatement->execute(['id' => $advertiser['agencyId']]);
            $agency = $agencyStatement->fetch();
        }

        $isFavourite = false;
        if (!is_null($user)) {
            $statement = $this->pdo->prepare("SELECT * FROM realEstate.FavouriteUserEstate WHERE userId = :userId AND estateId = :estateId");
            $statement->execute(['userId' => $user->id, 'estateId' => $id]);
            $isFavourite = $statement->rowCount() > 0;
        }


        return new EstateSingle($rowEstate,
            new UserForEstate($advertiser, $agency),
            $averagePrice,
            array_map(fn($x) => $x['id'], $rowPerks),
            $isFavourite);
    }

    public function searchEstatesByUser(SearchEstate $estate, string $userId, int $limit, int $offset): array
    {
        $query = "SELECT E.id, E.name, C.name as cityName, M.name as municipalityName, ML.name as microLocationName, E.surface, E.numberOfRooms, E.floor, E.description, E.price, ML.id as microLocationId, E.images, E.sold";

        $query .= " " . $this->getQueryPartForSearch($estate);
        $query .= " AND E.advertiserId = :advertiserId";
        $query .= "\nLIMIT $limit";
        $queryParameters = $estate->convertToArray();
        $queryParameters['advertiserId'] = $userId;
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
                $row['images'],
                $row['sold']
            );
        }

        return $results;
    }

    public function countEstatesByUser(SearchEstate $estate, string $userId): int
    {
        $query = "SELECT COUNT(*) ";
        $query .= $this->getQueryPartForSearch($estate);
        $query .= " AND E.advertiserId = :advertiserId";
        $statement = $this->pdo->prepare($query);
        $queryParameters = $estate->convertToArray();
        $queryParameters['advertiserId'] = $userId;
        $statement->execute($queryParameters);

        return $statement->fetchColumn();
    }

    public function getEstateForEdit(string $id): ?EstateForEditing
    {
        $statement = $this->pdo->prepare("SELECT id, price, name, surface, numberOfRooms, typeId, constructionDate,
            conditionId, heatingId, floor, totalFloors, description, streetId, streetNumber, busLines, images, advertiserId, sold
            FROM realEstate.Estate WHERE id = :id");

        $statement->execute(['id' => $id]);
        $estate = $statement->fetch();

        if (is_null($estate)) {
            return null;
        }

        $statementPerks = $this->pdo->prepare("SELECT perkId FROM realEstate.EstatePerk WHERE estateId = :id;");
        $statementPerks->execute(['id' => $id]);
        $estate['perks'] = [];
        foreach ($statementPerks->fetchAll() as $row) {
            $estate['perks'] []= $row['perkId'];
        }

        return ArraySerializer::deserialize(EstateForEditing::class, $estate);
    }

    public function deleteEstate(Estate $estate)
    {
        $this->delete($estate);
    }

    public function getEstateById(string $id): ?Estate
    {
        $statement = $this->pdo->prepare("SELECT * FROM realEstate.Estate WHERE id = :id AND sold = false");
        $statement->execute(['id' => $id]);
        return ArraySerializer::deserialize(Estate::class, $statement->fetch());
    }

    public function sellEstate(string $id)
    {
        $statement = $this->pdo->prepare("UPDATE realEstate.Estate SET sold = 1 AND dateSold = NOW() WHERE id = :id");
        $statement->execute(['id'=>$id]);
    }

    public function addToFavourites(Estate $estate, User $user)
    {
        $statement = $this->pdo->prepare("INSERT INTO realEstate.FavouriteUserEstate(userId, estateId)
            VALUES(:userId, :estateId)");
        $statement->execute(['userId' => $user->id, 'estateId' => $estate->id]);
    }

    public function countFavourites(User $user): int
    {
        $statement = $this->pdo->prepare("SELECT COUNT(*) 
            FROM realEstate.FavouriteUserEstate 
            WHERE userId = :userId");
        $statement->execute(['userId' => $user->id]);
        return $statement->fetchColumn();
    }

    public function removeFromFavourites(Estate $estate, User $user)
    {
        $statement = $this->pdo->prepare("DELETE
            FROM realEstate.FavouriteUserEstate 
            WHERE estateId = :estateId AND userId = :userId");
        $statement->execute(['estateId' => $estate->id, 'userId' => $user->id]);
    }

    public function getFavourites(User $user): array
    {
        $statement = $this->pdo->prepare("SELECT E.id, E.name, C.name as cityName, 
            M.name as municipalityName, ML.name as microLocationName, E.surface, E.numberOfRooms, 
            E.floor, E.description, E.price, ML.id as microLocationId, E.images, E.sold
            FROM realEstate.Estate E
            JOIN realEstate.Street S on E.streetId = S.id
            JOIN realEstate.MicroLocation ML on ML.id = S.microLocationId
            JOIN realEstate.Municipality M on ML.municipalityId = M.id
            JOIN realEstate.City C on M.cityId = C.id
            JOIN realEstate.FavouriteUserEstate FU on FU.estateId = E.id
            WHERE FU.userId = :userId");

        $statement->execute(['userId' => $user->id]);
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
                $row['images'],
                $row['sold']
            );
        }

        return $results;
    }
}