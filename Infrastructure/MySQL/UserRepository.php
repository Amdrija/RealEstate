<?php

namespace Amdrija\RealEstate\Application\Infrastructure\MySQL;

use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Framework\ArraySerializer;
use ReflectionException;

class UserRepository extends Repository implements IUserRepository
{
    /**
     * @throws ReflectionException
     */
    public function getUserByUserName(string $userName): ?User
    {
        $statement = $this->pdo->prepare("SELECT * FROM realEstate.User WHERE userName = :userName LIMIT 1;");
        $statement->execute(['userName' => $userName]);

        $user = $statement->fetch();
        if ($user == null) {
            return null;
        }

        /** @var User $userObject */
        $userObject = ArraySerializer::deserialize(User::class, $user);

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
        if ($user == null) {
            return null;
        }

        /** @var User $userObject */
        $userObject = ArraySerializer::deserialize(User::class, $user);

        return $userObject;
    }

    public function saveUser(User $user): User
    {
        /* @var $user User */
        $user = parent::insert($user);

        return $user;
    }
}