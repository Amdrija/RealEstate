<?php

namespace Amdrija\RealEstate\Application\Exceptions\User;

use Throwable;

class UsernameTakenException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("Username taken.");
    }
}