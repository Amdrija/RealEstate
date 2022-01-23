<?php

namespace Amdrija\RealEstate\Application\Exceptions\User;

use Amdrija\RealEstate\Application\Exceptions\ApplicationException;
use Throwable;

class UserNotFound extends ApplicationException
{
    public function __construct()
    {
        parent::__construct("User not found.");
    }
}