<?php

namespace Amdrija\RealEstate\Application\RequestModels\User;

class EditUserContact
{
    public string $cityId;
    public string $telephone;
    public string $email;
    public ?string $agencyId;
}