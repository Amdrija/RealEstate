<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IEstateRepository;
use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\Models\Perk;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
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
}