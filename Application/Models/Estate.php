<?php

namespace Amdrija\RealEstate\Application\Models;

use DateTime;

class Estate extends Entity
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
    public string $advertiserId;
    public string $streetId;
    public int $streetNumber;
    public string $busLines;
    public string $images;
    public string $sold;
}