<?php

namespace Amdrija\RealEstate\Framework;

class DependencyInjectionContainer
{
    private static array $services = [];

    public static function register(string $interface, string $implementation)
    {
        self::$services[$interface] = $implementation;
    }

    public static function registerClass(string $className)
    {
        self::register($className, $className);
    }

    /**
     * @throws \ReflectionException
     */
    public static function make(string $className): ?object
    {
        if ($className == \PDO::class) {
            return self::makePDO();
        }

        $class = new \ReflectionClass(self::$services[$className]);
        $constructor = $class->getConstructor();

        if (is_null($constructor)) {
            return new $className;
        }

        $arguments = [];
        foreach ($constructor->getParameters() as $dependency) {
            $arguments[] = self::make($dependency->getType()->getName());
        }

        return $class->newInstanceArgs($arguments);
    }

    private static function makePDO(): \PDO
    {
        $host = getenv('HOST');
        $db = getenv('MYSQL_DATABASE');
        $dsn = "mysql:host={$host};dbname={$db};port=3306;charset=utf8mb4";

        return new \PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
    }
}