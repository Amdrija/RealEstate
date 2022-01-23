<?php

namespace Amdrija\RealEstate\Application\Exceptions\User;

use Throwable;

class LicenceNumberRequiredForAgentException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("Licence number is required if you specify an agency.");
    }
}