<?php

namespace Amdrija\RealEstate\Application\Exceptions\Estate;

class EstateNotFoundException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("Estate not found.");
    }
}