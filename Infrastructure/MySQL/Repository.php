<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\Entity;
use Carbon\Traits\Date;
use PDO;
use ReflectionClass;

class Repository
{
    protected PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getList(string $className, int $count = -1, int $offset = 0): array
    {
        $class = new ReflectionClass($className);

        $query = "SELECT  * FROM {$class->getShortName()}";
        if ($count >= 0) {
            $query .= " LIMIT $count";
        }

        if ($offset > 0) {
            $query .= " OFFSET $offset";
        }

        $entities = [];
        foreach ($this->pdo->query($query)->fetchAll() as $row) {
            $entity = $class->newInstanceWithoutConstructor();
            foreach ($class->getProperties() as $property) {
                $property->setValue($entity, $row[$property->name]);
            }

            $entities[] = $entity;
        }
        return $entities;
    }

    public function insert(Entity $entity): Entity
    {
        $statement = $this->pdo->prepare(self::getInsertQuery($entity));
        $statement->execute(self::convertObjectToArrayForQuery($entity));

        return $entity;
    }

    private static function getInsertQuery(object $object): string
    {
        $class = new ReflectionClass($object);

        $insertPropertyNames = join(",", array_map(fn($x) => "$x->name", $class->getProperties()));
        $valueParameters = join(",", array_map(fn($x) => ":$x->name", $class->getProperties()));

        $tableName = $class->getShortName();
        return "INSERT INTO $tableName ($insertPropertyNames) VALUES ($valueParameters);";
    }

    private static function convertObjectToArrayForQuery(object $object): array
    {
        $array = [];
        $class = new ReflectionClass($object);

        foreach ($class->getProperties() as $property) {
            if ($property->getType() == \DateTime::class) {
                $array[$property->name] = $property->getValue($object)->format("Y-m-d");
            } elseif (is_bool($property->getValue($object))) {
                $array[$property->name] = (int)$property->getValue($object);
            } else {
                $array[$property->name] = $property->getValue($object);
            }

        }

        return $array;
    }
}