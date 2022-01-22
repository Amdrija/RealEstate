<?php

namespace Amdrija\RealEstate\Application\Models;

class Agency extends Entity
{
    public string $name;
    public string $pib;
    public string $streetId;
    public int $number;

    public function __construct(string $name, string $pib, string $streetId, int $number)
    {
        parent::__construct();
        $this->name = $name;
        $this->pib = $pib;
        $this->streetId = $streetId;
        $this->number = $number;
    }
}