<?php

namespace Amdrija\RealEstate\Application\RequestModels\Estate;

use DateTime;

class AddEstate
{
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
    public array $busLines;
    public array $perks = [];
}