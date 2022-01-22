<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Exceptions\User\ConfirmedPasswordMismatchException;
use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\User\RegisterUser;
use DateTime;

class UserService
{
    private readonly IUserRepository $userRepository;

    /**
     * @param IUserRepository $userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws ConfirmedPasswordMismatchException
     */
    public function registerUser(RegisterUser $registerUser): User
    {
        if (!$registerUser->isPasswordConfirmed()) {
            throw new ConfirmedPasswordMismatchException();
        }

        $user = new User();
        $user->userName = $registerUser->userName;
        $user->birthDate = $registerUser->birthDate;
        $user->cityId = $registerUser->cityId;
        $user->email = $registerUser->email;
        $user->firstName = $registerUser->firstName;
        $user->isAdministrator = false;
        $user->lastName = $registerUser->lastName;
        $user->password = password_hash($registerUser->password, PASSWORD_DEFAULT);
        $user->telephone = $registerUser->password;
        $user->verified = true;
        $user->agencyId = $registerUser->agencyId;
        $user->licenceNumber = $registerUser->licenceNumber;

        return $this->userRepository->saveUser($user);
    }
}