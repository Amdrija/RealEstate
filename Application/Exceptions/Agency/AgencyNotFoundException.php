<?php

namespace Amdrija\RealEstate\Application\Exceptions\Agency;

class AgencyNotFoundException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("Agency not found");
    }
}