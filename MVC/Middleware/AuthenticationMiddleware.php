<?php

namespace Amdrija\RealEstate\MVC\Middleware;

use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Framework\Exceptions\HttpUnauthorizedException;
use Amdrija\RealEstate\Framework\Middleware;

class AuthenticationMiddleware implements Middleware
{
    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Authenticates the current user, returns true if the authentication was successful
     * and throws HttpUnauthorizedException if the authentication failed.
     * @return bool
     * @throws HttpUnauthorizedException
     */
    public function execute(): bool
    {
        if ($this->loginService->isSessionActive() || $this->loginService->automaticLogIn()) {
            return true;
        }

        throw new HttpUnauthorizedException();
    }
}