<?php

namespace Amdrija\RealEstate\Application\Interfaces;

use Amdrija\RealEstate\Application\Exceptions\User\EmailTakenException;
use Amdrija\RealEstate\Application\Exceptions\User\UsernameTakenException;
use Amdrija\RealEstate\Application\Models\User;

interface IUserRepository
{
    public function getUserByUserName(string $userName): ?User;

    public function setUserToken(User $user, string $token);

    public function getUserByToken(string $token): ?User;

    /**
     * @throws UsernameTakenException
     * @throws EmailTakenException
     */
    public function saveUser(User $user): User;
}