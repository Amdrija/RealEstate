<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Exceptions\User\ConfirmedPasswordMismatchException;
use Amdrija\RealEstate\Application\Exceptions\User\EmailTakenException;
use Amdrija\RealEstate\Application\Exceptions\User\LicenceNumberRequiredForAgentException;
use Amdrija\RealEstate\Application\Exceptions\User\UsernameTakenException;
use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Models\User;
use Amdrija\RealEstate\Application\RequestModels\PaginatedResponse;
use Amdrija\RealEstate\Application\RequestModels\Pagination;
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

    public function listUsers(array $queryParameters): PaginatedResponse
    {
        $userCount = $this->userRepository->getUserCount();
        $pagination = Pagination::create($queryParameters, $userCount);

        return new PaginatedResponse($pagination,
            $this->userRepository->getUsers($pagination->pageSize, $pagination->getOffset()));
    }

    /**
     * @param RegisterUser $registerUser
     * @return User
     * @throws ConfirmedPasswordMismatchException
     * @throws EmailTakenException
     * @throws UsernameTakenException|LicenceNumberRequiredForAgentException
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
        $user->verified = false;
        if ($registerUser->agencyId != ""){
            $user->agencyId = $registerUser->agencyId;
            if ($registerUser->licenceNumber == 0) {
                throw new LicenceNumberRequiredForAgentException();
            }
            $user->licenceNumber = $registerUser->licenceNumber;
        } else {
            $user->agencyId = null;
            $user->licenceNumber = null;
        }

        return $this->userRepository->saveUser($user);
    }
}