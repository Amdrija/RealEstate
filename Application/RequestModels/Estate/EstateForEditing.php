<?php

namespace Amdrija\RealEstate\Application\RequestModels\Estate;

use DateTime;

class EstateForEditing
{
    public string $id;
    public int $price;
    public string $name;
    public float $surface;
    public int $numberOfRooms;
    public int $typeId;
    public DateTime $constructionDate;
    public int $conditionId;
    public int $heatingId;
    public int $floor;
    public int $totalFloors;
    public string $description;
    public string $streetId;
    public int $streetNumber;
    public string $busLines;
    public array $perks = [];
    public string $advertiserId;
    public string $images;
    public string $sold;
}