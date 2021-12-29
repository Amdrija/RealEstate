<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use DateTime;
use Exception;
use ReflectionClass;
use ReflectionException;

class ModelFactory
{
    /**
     * @throws ReflectionException
     */
    public static function constructModel(string $className, array $array): object
    {
        $class = new ReflectionClass($className);
        $object = $class->newInstanceWithoutConstructor();

        foreach ($class->getProperties() as $property)
        {
            if ($property->getType()->getName() == DateTime::class)
            {
                try {
                    $array[$property->name] = new DateTime($array[$property->name]);
                } catch (Exception) {
                    $array[$property->name] = new DateTime();
                }
            } elseif ($property->getType()->getName() == "int") {
                $array[$property->name] = (int)$array[$property->name];
            } elseif ($property->getType()->getName() == "float") {
                $array[$property->name] = (float)$array[$property->name];
            }
            $property->setValue($object, $array[$property->name]);
        }

        return $object;
    }
}