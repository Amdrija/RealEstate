<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForEditing;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSingle;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;

interface IEstateRepository
{
    public function searchEstatesByUser(SearchEstate $estate, string $userId, int $limit, int $offset): array;
    public function countEstatesByUser(SearchEstate $estate, string $userId): int;
    public function searchEstates(SearchEstate $estate, int $limit, int $offset): array;
    public function countEstates(SearchEstate $estate): int;

    public function getEstateForEdit(string $id): ?EstateForEditing;

    public function getSingleEstateById(string $id): ?EstateSingle;

    public function getLatest(int $count): array;

    public function createEstate(AddEstate $estate, array $images, string $id, string $advertiserId): Estate;

    public function editEstate(AddEstate $estate, array $images, string $id): Estate;
}