<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Exceptions\User\EmailTakenException;
use Amdrija\RealEstate\Application\Exceptions\User\UsernameTakenException;
use Amdrija\RealEstate\Application\Models\User;

interface IUserRepository
{
    public function deleteUserToken(string $id);

    public function getUserById(string $id): ?User;

    public function getUserCount(): int;

    public function getUsers(int $count = -1, int $offset = 0): array;

    public function getUserByUserName(string $userName): ?User;

    public function setUserToken(User $user, string $token);

    public function getUserByToken(string $token): ?User;

    /**
     * @throws UsernameTakenException
     * @throws EmailTakenException
     */
    public function saveUser(User $user): User;
    /**
     * @throws UsernameTakenException
     * @throws EmailTakenException
     */
    public function editUser(User $user): User;
}