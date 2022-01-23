<?php

namespace Amdrija\RealEstate\Application\Exceptions\User;

use Throwable;

class EmailTakenException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct(string $email)
    {
        parent::__construct("User with email: $email already exists.");
    }
}