<?php

namespace Amdrija\RealEstate\Application\RequestModels\User;

use DateTime;

class EditUser
{
    public string $firstName;
    public string $lastName;
    public string $userName;
    public string $cityId;
    public DateTime $birthDate;
    public string $telephone;
    public string $email;
    public ?string $agencyId;
    public ?int $licenceNumber;
    public bool $verified;
    public bool $isAdministrator;
}