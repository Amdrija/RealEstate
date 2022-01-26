<?php

namespace Amdrija\RealEstate\Application\RequestModels\Estate;

class SearchEstate
{
    public int $priceFrom;
    public int $priceUpTo;
    public float $surfaceFrom;
    public float $surfaceUpTo;
    public int $roomsFrom;
    public int $roomsUpTo;
    public int $yearFrom;
    public int $yearUpTo;
    public int $floorFrom;
    public int $floorUpTo;
    public ?string $cityId;
    public ?array $microLocationIds;
    public ?int $conditionId;
    public ?int $typeId;

    public function __construct(array $queryParameters)
    {
        $this->priceFrom = (int)self::getFromValue($queryParameters, 'priceFrom');
        $this->priceUpTo = (int)self::getUpToValue($queryParameters, 'priceUpTo');
        $this->surfaceFrom = (float)self::getFromValue($queryParameters, 'surfaceFrom');
        $this->surfaceUpTo = (float)self::getUpToValue($queryParameters, 'surfaceUpTo');
        $this->roomsFrom = (int)self::getFromValue($queryParameters, 'roomsFrom');
        $this->roomsUpTo = (int)self::getUpToValue($queryParameters, 'roomsUpTo');
        $this->yearFrom = (int)self::getFromValue($queryParameters, 'yearFrom');
        $this->yearUpTo = (int)self::getUpToValue($queryParameters, 'yearUpTo');
        $this->floorFrom = (int)self::getFromValue($queryParameters, 'floorFrom');
        $this->floorUpTo = (int)self::getUpToValue($queryParameters, 'floorUpTo');
        $this->microLocationIds = self::getMicroLocations($queryParameters);
        $this->cityId = self::getCityId($queryParameters, $this->microLocationIds);
        $this->conditionId = self::getNullable($queryParameters, 'conditionId');
        $this->typeId = self::getNullable($queryParameters, 'typeId');
    }

    public static function getFromValue(array $queryParameters, string $key)
    {
        return isset($queryParameters[$key]) && $queryParameters[$key] != "" ? $queryParameters[$key] : 0;
    }

    public static function getUpToValue(array $queryParameters, string $key)
    {
        return isset($queryParameters[$key]) && $queryParameters[$key] != "" ? $queryParameters[$key] : PHP_INT_MAX;
    }

    public static function getNullable(array $queryParameters, string $key)
    {
        return isset($queryParameters[$key]) && $queryParameters[$key] != "" ? $queryParameters[$key] : null;
    }

    private static function getMicroLocations(array $queryParameters) {
        $microLocations = self::getNullable($queryParameters, 'microLocationIds');
        if (is_null($microLocations)) {
            return null;
        }
        $microLocations = array_filter($microLocations, fn($x) => $x != "");

        return empty($microLocations) ? null : $microLocations;
    }

    public static function getCityId(array $queryParameters, ?array $microLocations)
    {
        if (!is_null($microLocations)) {
            return null;
        }

        return self::getNullable($queryParameters, 'cityId');
    }

    public function convertToArray(): array
    {
        $array = [];
        $array['priceFrom'] = $this->priceFrom;
        $array['priceUpTo'] = $this->priceUpTo;
        $array['surfaceFrom'] = $this->surfaceFrom;
        $array['surfaceUpTo'] = $this->surfaceUpTo;
        $array['roomsFrom'] = $this->roomsFrom;
        $array['roomsUpTo'] = $this->roomsUpTo;
        $array['yearFrom'] = $this->yearFrom;
        $array['yearUpTo'] = $this->yearUpTo;
        $array['floorFrom'] = $this->floorFrom;
        $array['floorUpTo'] = $this->floorUpTo;

        if (!is_null($this->cityId)) {
            $array['cityId'] = $this->cityId;
        }

        if (!is_null($this->microLocationIds)) {
            $array['microLocationIds'] = join(",", $this->microLocationIds);
        }

        if (!is_null($this->conditionId)) {
            $array['conditionId'] = $this->conditionId;
        }

        if (!is_null($this->typeId)) {
            $array['typeId'] = $this->typeId;
        }

        return $array;
    }
}