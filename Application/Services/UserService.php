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
use Amdrija\RealEstate\Application\RequestModels\User\EditUser;
use Amdrija\RealEstate\Application\RequestModels\User\EditUserContact;
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

    public function getUserById(string $id): ?User
    {
        return $this->userRepository->getUserById($id);
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
    public function registerUser(RegisterUser $registerUser, bool $isAdministrator = false, bool $verified = false): User
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
        $user->isAdministrator = $isAdministrator;
        $user->lastName = $registerUser->lastName;
        $user->password = password_hash($registerUser->password, PASSWORD_DEFAULT);
        $user->telephone = $registerUser->telephone;
        $user->verified = $verified;
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

    /**
     * @param EditUser $editUser
     * @param User $user
     * @return User
     * @throws EmailTakenException
     * @throws LicenceNumberRequiredForAgentException
     * @throws UsernameTakenException
     */
    public function editUser(EditUser $editUser, User $oldUser): User
    {
        $user = new User();
        $user->id = $oldUser->id;
        $user->password = $oldUser->password;
        $user->userName = $editUser->userName;
        $user->birthDate = $editUser->birthDate;
        $user->cityId = $editUser->cityId;
        $user->email = $editUser->email;
        $user->firstName = $editUser->firstName;
        $user->isAdministrator = $editUser->isAdministrator;
        $user->lastName = $editUser->lastName;
        $user->telephone = $editUser->telephone;
        $user->verified = $editUser->verified;
        if ($editUser->agencyId != ""){
            $user->agencyId = $editUser->agencyId;
            if ($editUser->licenceNumber == 0) {
                throw new LicenceNumberRequiredForAgentException();
            }
            $user->licenceNumber = $editUser->licenceNumber;
        } else {
            $user->agencyId = null;
            $user->licenceNumber = null;
        }

        return $this->userRepository->editUser($user);
    }

    public function deleteUser(User $user)
    {
        //TODO: Cacade delete user houses.
        $this->userRepository->deleteUser($user);
    }

    /**
     * @param EditUserContact $editUser
     * @param User $oldUser
     * @return User
     * @throws EmailTakenException
     * @throws UsernameTakenException
     */
    public function editUserContact(EditUserContact $editUser, User $oldUser): User
    {
        $user = new User();
        $user->id = $oldUser->id;
        $user->password = $oldUser->password;
        $user->userName = $oldUser->userName;
        $user->birthDate = $oldUser->birthDate;
        $user->cityId = $editUser->cityId;
        $user->email = $editUser->email;
        $user->firstName = $oldUser->firstName;
        $user->isAdministrator = $oldUser->isAdministrator;
        $user->lastName = $oldUser->lastName;
        $user->telephone = $editUser->telephone;
        $user->verified = $oldUser->verified;
        if ($editUser->agencyId != "" && $oldUser->agencyId != null){
            $user->agencyId = $editUser->agencyId;
            $user->licenceNumber = $oldUser->licenceNumber;
        } else {
            $user->agencyId = null;
            $user->licenceNumber = null;
        }

        return $this->userRepository->editUser($user);
    }
}