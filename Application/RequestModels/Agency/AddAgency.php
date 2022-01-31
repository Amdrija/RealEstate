<?php

namespace Amdrija\RealEstate\Application\RequestModels\Agency;

class AddAgency
{
    public string $name;
    public string $pib;
    public string $streetId;
    public int $streetNumber;
}