<?php

namespace Amdrija\RealEstate\Application\Models;

use DateTime;

class User extends Entity
{
    public string $firstName;
    public string $lastName;
    public string $userName;
    public string $password;
    public int $cityId;
    public DateTime $birthDate;
    public string $telephone;
    public string $email;
    public int $agencyId;
    public int $licenceNumber;
    public bool $verified;
    public bool $isAdministrator;
}