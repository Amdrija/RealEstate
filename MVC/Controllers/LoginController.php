<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Framework\Responses\HTMLResponse;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class LoginController extends FrontController
{
    private LoginService $loginService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        parent::__construct();
        $this->loginService = $loginService;
    }

    /**
     * Index action of the Log in controller.
     * Returns a response that has log in page content.
     * @return Response
     */
    public function index(): Response
    {
        if ($this->loginService->isSessionActive() || $this->loginService->automaticLogIn()) {
            return new RedirectResponse('/admin');
        }

        return $this->buildHtmlResponse('login', ['title' => 'Log In']);
    }

    /**
     * Log in action of the Log in controller.
     * Tries to log the user in. Upon successful login, returns the response
     * of the Admin controller action.
     * Upon unsuccessful login, return Error404 response.
     * @return Response
     */
    public function logIn(): Response
    {
        $body = $this->request->getBody();

        if (!isset($body['username']) || !isset($body['password'])) {
            return $this->buildHtmlResponse('login', ['title' => 'Log In', 'error' => 'Login unsuccessful']);
        }

        $keepMeLoggedIn = isset($body['keepMeLoggedIn']);
        if (!$this->loginService->logIn($body['username'], $body['password'], $keepMeLoggedIn)) {
            return $this->buildHtmlResponse('login', ['title' => 'Log In', 'error' => 'Login unsuccessful']);
        }

        return new RedirectResponse('/admin');
    }
}