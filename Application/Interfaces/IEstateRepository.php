<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\Models\User;
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

    public function getSingleEstateById(string $id, ?User $user): ?EstateSingle;

    public function getEstateById(string $id): ?Estate;

    public function getLatest(int $count): array;

    public function createEstate(AddEstate $estate, array $images, string $id, string $advertiserId): Estate;

    public function editEstate(AddEstate $estate, array $images, string $id): Estate;

    public function deleteEstate(Estate $estate);

    public function sellEstate(string $id);

    public function removeFromFavourites(Estate $estate, User $user);

    public function addToFavourites(Estate $estate, User $user);

    public function countFavourites(User $user): int;

    public function getFavourites(User $user): array;
}