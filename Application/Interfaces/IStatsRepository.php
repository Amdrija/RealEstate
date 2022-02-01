<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\Stats;

interface IStatsRepository
{
    public function getStatsByMicroLocation(string $microLocationId): Stats;

    public function getStatsByAgency(string $agencyId): Stats;
}