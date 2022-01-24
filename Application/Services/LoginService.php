<?php

namespace Amdrija\RealEstate\Application\Services;

use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Models\User;

class LoginService
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Checks if the Admin with the specified username and password is registered.
     * If it is, this function initializes the session and initializes the userToken cookie
     * if $keepMeLoggedIn is true. Then the function returns true if the login was successful.
     * If the admin with specified credentials doesn't exist, the method returns false.
     * @param string $username
     * @param string $password
     * @param bool $keepMeLoggedIn
     * @return bool
     */
    public function logIn(string $username, string $password, bool $keepMeLoggedIn): bool
    {
        $user = $this->checkLoginCredentials($username, $password);
        if ($user === null) {
            return false;
        }

        if (!$user->verified) {
            return false;
        }

        if ($keepMeLoggedIn) {
            $this->initializeUserToken($user);
        }

        $this->initializeSession($user->id);

        return true;
    }

    public function logOut()
    {
        if ($this->isSessionActive()) {
            $this->userRepository->deleteUserToken($_SESSION['userId']);
            unset($_SESSION['userId']);
        }
    }

    /**
     * Returns true and initializes the session if the cookie matches
     * an admin token. Otherwise, returns false.
     * @return bool
     */
    public function automaticLogIn(): bool
    {
        $user = $this->isLoginRemembered();

        if ($user === null) {
            return false;
        }

        $this->initializeSession($user->id);

        return true;
    }

    public function isAdminLoggedIn(): bool
    {
        $user = $this->isSessionActive() ? $this->userRepository->getUserById($_SESSION['userId']): $this->isLoginRemembered();
        return !is_null($user) && $user->isAdministrator;
    }

    /**
     * Returns true if there is an active session.
     * A session is active if a $_SESSION['userId'] is set.
     * @return bool
     */
    public function isSessionActive(): bool
    {
        return isset($_SESSION['userId']);
    }

    /**
     * Returns Admin id if the Admin user with the specified credentials exists.
     * Otherwise, if it doesn't exist, the method returns false.
     * @param string $username
     * @param string $password
     * @return User|null
     */
    private function checkLoginCredentials(string $username, string $password): ?User
    {
        $user = $this->userRepository->getUserByUsername($username);

        return $user !== null && password_verify($password, $user->password) ? $user : null;
    }

    /**
     * Initializes the 'Keep me logged in token' and saves it in the database.
     * @param User $user
     */
    private function initializeUserToken(User $user)
    {
        $token = uniqid();
        setcookie('userToken', $token, time() + 60 * 60 * 24 * 365);

        $this->userRepository->setUserToken($user, $token);
    }

    /**
     * Initializes the $_SESSION['userId'] to be the specified userId
     * @param string $userId
     */
    private function initializeSession(string $userId)
    {
        $_SESSION['userId'] = $userId;
    }

    /**
     * Returns the Admin id if there is an admin with the Token that is the same
     * as the $_COOKIE['userToken']. Otherwise, return false.
     * @return User|null
     */
    private function isLoginRemembered(): ?User
    {
        if (!isset($_COOKIE['userToken'])) {
            return null;
        }

        return $this->userRepository->getUserByToken($_COOKIE['userToken']);
    }

    public function getCurrentUser(): ?User
    {
        if($this->isSessionActive()) {
            return $this->userRepository->getUserById($_SESSION['userId']);
        }

        return $this->isLoginRemembered();
    }
}