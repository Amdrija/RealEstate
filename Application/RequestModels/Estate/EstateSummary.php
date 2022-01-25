<?php

namespace Amdrija\RealEstate\Application\RequestModels\Estate;

class EstateSummary
{
    public string $id;
    public string $name;
    public string $image;
    public int $price;
    public float $surface;
    public string $busLines;
    public string $numberOfRooms;

    public function __construct(string $id, string $name, int $price, float $surface, string $busLines, string $images, string $numberOfRooms)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->surface = $surface;
        $this->busLines = $busLines;
        $this->image =  explode(",",$images)[0];
        $this->numberOfRooms = $numberOfRooms;
    }
}