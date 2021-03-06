<?php

namespace Amdrija\RealEstate\Application\Models;

use DateTime;

class User extends Entity
{
    public function __construct()
    {
        parent::__construct();
        $this->verified = false;
        $this->isAdministrator = false;
    }

    public string $firstName;
    public string $lastName;
    public string $userName;
    public string $password;
    public string $cityId;
    public DateTime $birthDate;
    public string $telephone;
    public string $email;
    public ?string $agencyId;
    public ?int $licenceNumber;
    public bool $verified;
    public bool $isAdministrator;
}