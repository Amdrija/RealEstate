<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Interfaces\IEstateRepository;
use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSingle;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;
use Amdrija\RealEstate\Application\RequestModels\Pagination;
use Amdrija\RealEstate\Application\Uuid;
use Amdrija\RealEstate\Framework\ImageService;

class EstateService
{
    private readonly IEstateRepository $estateRepository;
    private readonly ImageService $imageService;
    private const LATEST_ESTATE_COUNT = 6;

    public function __construct(IEstateRepository $estateRepository, ImageService $imageService)
    {
        $this->estateRepository = $estateRepository;
        $this->imageService = $imageService;
    }

    public function createEstate(AddEstate $estate, array $images, User $user)
    {
        $uuid = Uuid::newUUID();
        $newImagesNames = array_map(fn ($e, $i) => "{$uuid}-{$i}{$e}" , $this->imageService->getImageExtensions($images), array_keys($images['name']));
        $newImagesURI = array_map(fn($i) => $this->imageService->imageRelativePath($i), $newImagesNames);
        $newEstate = $this->estateRepository->createEstate($estate, $newImagesURI, $uuid, $user->id);
        $this->imageService->moveTemporaryFiles($images, $this->imageService->imageSaveDirectory(), $newImagesNames);
    }

    public function searchEstates(SearchEstate $estate, array $queryParameters): PaginatedResponse
    {
        $userCount = $this->estateRepository->countEstates($estate);
        $pagination = Pagination::create($queryParameters, $userCount);
        return  new PaginatedResponse($pagination,$this->estateRepository->searchEstates($estate, $pagination->pageSize, $pagination->getOffset()));
    }

    public function getLatest(): array
    {
        return $this->estateRepository->getLatest(self::LATEST_ESTATE_COUNT);
    }

    public function getEstateSingle(string $id): ?EstateSingle
    {
        return $this->estateRepository->getSingleEstateById($id);
    }
}