<?php

namespace Amdrija\RealEstate\Application\Exceptions\User;

use Amdrija\RealEstate\Application\Exceptions\ApplicationException;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class ConfirmedPasswordMismatchException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct("Confirmed password not matching password.");
    }
}