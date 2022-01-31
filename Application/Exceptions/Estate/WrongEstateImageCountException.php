<?php

namespace Amdrija\RealEstate\Application\Exceptions\Estate;

class WrongEstateImageCountException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("An estates needs at least 3 and at most 6 images.");
    }
}