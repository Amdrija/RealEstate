<?php

namespace Amdrija\RealEstate\Application\RequestModels\Estate;

use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\User\UserForEstate;

class EstateSingle
{
    public string $id;
    public int $price;
    public string $name;
    public float $surface;
    public int $numberOfRooms;
    public string $type;
    public \DateTime $constructionDate;
    public string $condition;
    public string $heating;
    public int $floor;
    public int $totalFloors;
    public string $description;
    public UserForEstate $advertiser;
    public string $city;
    public string $municipality;
    public string $microLocation;
    public string $street;
    public int $streetNumber;
    public string $busLines;
    public array $images;
    public float $averagePrice;
    public array $perks;

    public function __construct(array $row, UserForEstate $advertiser, float $averagePrice, array $perks)
    {
        $this->id = $row['id'];
        $this->price = $row['price'];
        $this->name = $row['name'];
        $this->surface = $row['surface'];
        $this->numberOfRooms = $row['numberOfRooms'];
        $this->type = $row['type'];
        $this->constructionDate = new \DateTime($row['constructionDate']);
        $this->condition = $row['condition'];
        $this->heating = $row['heating'];
        $this->floor = $row['floor'];
        $this->totalFloors = $row['totalFloors'];
        $this->description = $row['description'];
        $this->advertiser = $advertiser;
        $this->city = $row['city'];
        $this->municipality = $row['municipality'];
        $this->microLocation = $row['microLocation'];
        $this->street = $row['street'];
        $this->streetNumber = $row['streetNumber'];
        $this->busLines = $row['busLines'];
        $this->images = explode(",", $row['images']);
        $this->averagePrice = $averagePrice;
        $this->perks = $perks;
    }
}