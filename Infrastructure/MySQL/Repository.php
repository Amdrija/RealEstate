<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Models\Entity;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Carbon\Traits\Date;
use Illuminate\Support\Arr;
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

    public function getById(string $className, string $id): ?object
    {
        $class = new ReflectionClass($className);
        $statement = $this->pdo->prepare("SELECT * FROM {$class->getShortName()} WHERE id = :id");

        $statement->execute(['id' => $id]);
        $row = $statement->fetch();
        if (!$row) {
            return null;
        }
        return ArraySerializer::deserialize($className, $row);
    }

    public function getCount(string $className)
    {
        $class = new ReflectionClass($className);
        return $this->pdo->query("SELECT COUNT(*) FROM {$class->getShortName()}")->fetchColumn();
    }

    public function getList(string $className,int $count = -1, int $offset = 0): array
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
            $entities[] = ArraySerializer::deserialize($className, $row);
        }
        return $entities;
    }

    public function delete(Entity $entity)
    {
        $class = new ReflectionClass($entity);
        $statement = $this->pdo->prepare("DELETE FROM {$class->getShortName()} WHERE id = :id");
        $statement->execute(['id' => $entity->id]);
    }

    public function insert(Entity $entity): Entity
    {
        $statement = $this->pdo->prepare(self::getInsertQuery($entity));
        $statement->execute(self::convertObjectToArrayForQuery($entity));

        return $entity;
    }

    public function edit(Entity $entity): Entity
    {
        $statement = $this->pdo->prepare(self::getUpdateQuery($entity));
        $statement->execute(self::convertObjectToArrayForQuery($entity));

        return $entity;
    }

    private static function getUpdateQuery(Entity $object): string
    {
        $class = new ReflectionClass($object);

        $propertiesForUpdate = array_filter($class->getProperties(), fn($x) => $x->name != "id");
        $setProperties = join(",", array_map(fn($x) => "$x->name = :$x->name", $propertiesForUpdate));

        $tableName = $class->getShortName();
        return "UPDATE $tableName SET $setProperties WHERE id = :id;";
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