<?php

namespace Amdrija\RealEstate\Application\Exceptions\Estate;

use Throwable;

class CannotEditSoldEstateException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("Cannot delete a sold estate.");
    }
}