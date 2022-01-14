<?php

namespace Amdrija\RealEstate\Application\RequestModels\User;

use DateTime;

class RegisterUser
{
    public string $firstName;
    public string $lastName;
    public string $userName;
    public string $password;
    public string $confirmedPassword;
    public string $cityId;
    public DateTime $birthDate;
    public string $telephone;
    public string $email;
    public ?string $agencyId;
    public ?int $licenceNumber;

    public function isPasswordConfirmed(): bool
    {
        return $this->password === $this->confirmedPassword;
    }
}