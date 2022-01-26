<?php

namespace Amdrija\RealEstate\Application\RequestModels\Estate;

class EstateForSearchResult
{
    public string $id;
    public string $name;
    public string $cityName;
    public string $municipalityName;
    public string $microLocationName;
    public float $surface;
    public int $numberOfRooms;
    public int $floor;
    public string $description;
    public int $price;
    public float $averagePrice;
    public string $image;

    public function __construct(string $id,
                                string $name,
                                string $cityName,
                                string $municipalityName,
                                string $microLocationName,
                                float $surface,
                                int $numberOfRooms,
                                int $floor,
                                string $description,
                                int $price,
                                float $averagePrice,
                                string $images)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cityName = $cityName;
        $this->municipalityName = $municipalityName;
        $this->microLocationName = $microLocationName;
        $this->surface = $surface;
        $this->numberOfRooms = $numberOfRooms;
        $this->floor = $floor;
        $this->description = $description;
        $this->price = $price;
        $this->averagePrice = $averagePrice;
        $this->image = explode(",", $images)[0];
    }
}