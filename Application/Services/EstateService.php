<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Exceptions\Estate\CannotEditSoldEstateException;
use Amdrija\RealEstate\Application\Exceptions\Estate\EstateNotFoundException;
use Amdrija\RealEstate\Application\Exceptions\Estate\MaximumFavouriteEstatesException;
use Amdrija\RealEstate\Application\Exceptions\Estate\WrongEstateImageCountException;
use Amdrija\RealEstate\Application\Interfaces\IEstateRepository;
use Amdrija\RealEstate\Application\Models\Estate;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\Estate\AddEstate;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateForEditing;
use Amdrija\RealEstate\Application\RequestModels\Estate\EstateSingle;
use Amdrija\RealEstate\Application\RequestModels\Estate\SearchEstate;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;
use Amdrija\RealEstate\Application\RequestModels\Pagination;
use Amdrija\RealEstate\Application\Uuid;
use Amdrija\RealEstate\Framework\Exceptions\FileNonExistentException;
use Amdrija\RealEstate\Framework\ImageService;

class EstateService
{
    private readonly IEstateRepository $estateRepository;
    private readonly ImageService $imageService;
    private const LATEST_ESTATE_COUNT = 6;
    private const MIN_IMAGE_COUNT = 3;
    private const MAX_IMAGE_COUNT = 6;
    private const MAX_FAVOURITE_COUNT = 5;

    public function __construct(IEstateRepository $estateRepository, ImageService $imageService)
    {
        $this->estateRepository = $estateRepository;
        $this->imageService = $imageService;
    }

    /**
     * @throws WrongEstateImageCountException
     * @throws FileNonExistentException
     */
    public function createEstate(AddEstate $estate, array $images, User $user)
    {
        $uuid = Uuid::newUUID();

        if (count($images['name']) < self::MIN_IMAGE_COUNT || count($images['name']) > self::MAX_IMAGE_COUNT) {
            throw new WrongEstateImageCountException();
        }

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

    public function searchEstatesByUserId(SearchEstate $estate, array $queryParameters, string $userId): PaginatedResponse
    {
        $userCount = $this->estateRepository->countEstatesByUser($estate, $userId);
        $pagination = Pagination::create($queryParameters, $userCount);
        return  new PaginatedResponse($pagination,$this->estateRepository->searchEstatesByUser($estate, $userId, $pagination->pageSize, $pagination->getOffset()));
    }

    public function getLatest(): array
    {
        return $this->estateRepository->getLatest(self::LATEST_ESTATE_COUNT);
    }

    public function getEstateSingle(string $id, ?User $user): ?EstateSingle
    {
        return $this->estateRepository->getSingleEstateById($id, $user);
    }

    public function getEstateForEdit(string $id, User $user): ?EstateForEditing
    {
        $estate = $this->estateRepository->getEstateForEdit($id);

        if ($user->id != $estate->advertiserId) {
            return null;
        }

        return $estate;
    }

    /**
     * @throws FileNonExistentException
     * @throws CannotEditSoldEstateException
     * @throws WrongEstateImageCountException
     */
    public function editEstate(AddEstate $estate, array $images, string $id, User $user)
    {
        $editEstate = $this->estateRepository->getEstateForEdit($id);
        if ($editEstate->sold) {
            throw new CannotEditSoldEstateException();
        }


        if ($user->id != $editEstate->advertiserId) {
            return null;
        }

        if (count($images['name']) > 1) {
            if (count($images['name']) < self::MIN_IMAGE_COUNT || count($images['name']) > self::MAX_IMAGE_COUNT) {
                throw new WrongEstateImageCountException();
            }

            $newImagesNames = array_map(fn ($e, $i) => "{$id}-{$i}{$e}" , $this->imageService->getImageExtensions($images), array_keys($images['name']));
            $newImagesURI = array_map(fn($i) => $this->imageService->imageRelativePath($i), $newImagesNames);
            $this->estateRepository->editEstate($estate, $newImagesURI, $id);
            $this->imageService->moveTemporaryFiles($images, $this->imageService->imageSaveDirectory(), $newImagesNames);
        } else {
            $this->estateRepository->editEstate($estate, explode(", ", $editEstate->images), $id);
        }
    }

    /**
     * @throws EstateNotFoundException
     */
    public function deleteEstate(string $id, User $user)
    {
        $estate = $this->estateRepository->getEstateById($id);
        if (is_null($estate)) {
            throw new EstateNotFoundException();
        }

        if ($user->id != $estate->advertiserId) {
            return;
        }

        $this->estateRepository->deleteEstate($estate);
        foreach (explode(", ",$estate->images) as $image) {
            try {
                $this->imageService->deleteImage($image);
            } catch (\Exception) {

            }
        }
    }

    /**
     * @throws EstateNotFoundException
     */
    public function sellEstate(string $id, User $user)
    {
        $estate = $this->estateRepository->getEstateById($id);
        if (is_null($estate)) {
            throw new EstateNotFoundException();
        }

        if ($user->id != $estate->advertiserId) {
            return;
        }

        $this->estateRepository->sellEstate($estate->id);
    }

    /**
     * @throws EstateNotFoundException
     * @throws MaximumFavouriteEstatesException
     */
    public function addToFavourites(string $id, User $user)
    {
        $estate = $this->estateRepository->getEstateById($id);

        if (is_null($estate)) {
            throw new EstateNotFoundException();
        }

        if ($this->estateRepository->countFavourites($user) >= self::MAX_FAVOURITE_COUNT) {
            throw new MaximumFavouriteEstatesException();
        }

        $this->estateRepository->addToFavourites($estate, $user);
    }

    /**
     * @throws EstateNotFoundException
     */
    public function removeFromFavourites(string $id, User $user)
    {
        $estate = $this->estateRepository->getEstateById($id);

        if (is_null($estate)) {
            throw new EstateNotFoundException();
        }

        $this->estateRepository->removeFromFavourites($estate, $user);
    }

    public function getFavouriteEstates(User $user, array $queryParameters): array
    {
        return  $this->estateRepository->getFavourites($user);
    }
}