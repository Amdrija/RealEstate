<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Models\User;
use PDO;
use ReflectionException;

class UserRepository implements IUserRepository
{
    private readonly PDO $pdo;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * @throws ReflectionException
     */
    public function getUserByUserName(string $userName): ?User
    {
        $statement = $this->pdo->prepare("SELECT * FROM realEstate.User WHERE userName = :userName LIMIT 1;");
        $statement->execute(['userName' => $userName]);

        $user = $statement->fetch();
        if ($user == null)
        {
            return null;
        }

        /** @var User $userObject */
        $userObject = ModelFactory::constructModel(User::class, $user);

        return $userObject;
    }

    public function setUserToken(User $user, string $token)
    {
        $statement = $this->pdo->prepare("UPDATE realEstate.User SET token = :token WHERE id = :id;");
        $statement->execute(['id' => $user->id, 'token' => $token]);
    }

    /**
     * @throws ReflectionException
     */
    public function getUserByToken(string $token): ?User
    {
        $statement = $this->pdo->prepare("SELECT * FROM realEstate.User WHERE token = :token LIMIT 1;");
        $statement->execute(['token' => $token]);

        $user = $statement->fetch();
        if ($user == null)
        {
            return null;
        }

        /** @var User $userObject */
        $userObject = ModelFactory::constructModel(User::class, $user);

        return $userObject;
    }
}