<?php

namespace Amdrija\RealEstate\Application\Exceptions\Estate;

class MaximumFavouriteEstatesException extends \Amdrija\RealEstate\Application\Exceptions\ApplicationException
{
    public function __construct()
    {
        parent::__construct("Maximum favourite estate count reached, you cannot add more.");
    }
}