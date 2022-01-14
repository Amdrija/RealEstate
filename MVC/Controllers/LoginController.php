<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\Exceptions\User\ConfirmedPasswordMismatchException;
use Amdrija\RealEstate\Application\RequestModels\User\RegisterUser;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\HTMLResponse;
use Amdrija\RealEstate\Framework\Responses\JSONResponse;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;

class LoginController extends FrontController
{
    private LoginService $loginService;
    private UserService $userService;

    /**
     * LoginController constructor.
     * @param LoginService $loginService
     * @param UserService $userService
     */
    public function __construct(LoginService $loginService, UserService $userService)
    {
        parent::__construct();
        $this->loginService = $loginService;
        $this->userService = $userService;
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
     * Index action of the Log in controller.
     * Returns a response that has log in page content.
     * @return Response
     */
    public function registerIndex(): Response
    {
        if ($this->loginService->isSessionActive() || $this->loginService->automaticLogIn()) {
            return new RedirectResponse('/admin');
        }

        return $this->buildHtmlResponse('register', ['title' => 'Register']);
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

    //TODO ADD Seriializer
    public function register(): Response
    {
        try {
            $this->userService->registerUser(new RegisterUser());
        } catch (ConfirmedPasswordMismatchException $exception) {
            return ErrorResponseFactory::getResponse("Potvrđena lozinka i lozinka nisu iste.", 400);
        }

        return new JSONResponse([]);
    }
}