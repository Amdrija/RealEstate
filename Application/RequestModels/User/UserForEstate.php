<?php

namespace Amdrija\RealEstate\Application\RequestModels\User;

class UserForEstate
{
    public string $firstName;
    public string $lastName;
    public string $telephone;
    public ?string $agencyName;
    public ?string $agencyPIB;
    public ?string $agencyStreet;
    public ?string $agencyCity;

    public function __construct(array $user, ?array $agency)
    {
        $this->firstName = $user['firstName'];
        $this->lastName = $user['lastName'];
        $this->telephone = $user['telephone'];
        if(is_null($agency)) {
            $this->agencyName = null;
            $this->agencyPIB = null;
            $this->agencyStreet = null;
            $this->agencyCity = null;
        } else {

            $this->agencyName = $agency['name'];
            $this->agencyPIB = $agency['pib'];
            $this->agencyStreet = $agency['street'];
            $this->agencyCity = $agency['city'];
        }
    }
}