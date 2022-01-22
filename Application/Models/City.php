<?php

namespace Amdrija\RealEstate\Application\Models;

class City extends Entity
{
    public string $name;

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }
}