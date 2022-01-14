<?php

namespace Amdrija\RealEstate\Application\Models;

use Amdrija\RealEstate\Application\Uuid;

class Entity
{
    public string $id;

    public function __construct()
    {
        $this->id = Uuid::newUUID();
    }
}