<?php

namespace Amdrija\RealEstate\MVC;

use Amdrija\RealEstate\Application\Infrastructure\MySQL\UserRepository;
use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\DependencyInjectionContainer;
use Amdrija\RealEstate\Framework\Router;
use Amdrija\RealEstate\MVC\Controllers\HomeController;
use Amdrija\RealEstate\MVC\Controllers\LoginController;
use Exception;

class Bootstrap
{
    /**
     * Function that initializes the app.
     * @throws Exception
     */
    public static function initialize()
    {
        session_start();
        self::initializeAdminRoutes();
        self::RegisterDependencies();
    }

    public static function RegisterDependencies()
    {
        DependencyInjectionContainer::register(IUserRepository::class, UserRepository::class);
        DependencyInjectionContainer::registerClass(LoginService::class);
        DependencyInjectionContainer::registerClass(LoginController::class);
        DependencyInjectionContainer::registerClass(HomeController::class);
        DependencyInjectionContainer::registerClass(UserService::class);
    }

    /**
     * Initializes Admin routes.
     * @throws Exception
     */
    private static function initializeAdminRoutes()
    {
        /* Login routes */
        Router::register(
            'GET',
            '/admin/login',
            ['controller' => LoginController::class, 'action' => 'index', 'middleware' => []]
        );
        Router::register(
            'POST',
            '/admin/login',
            ['controller' => LoginController::class, 'action' => 'login', 'middleware' => []]
        );
        Router::register(
            'GET',
            '/register',
            ['controller' => LoginController::class, 'action' => 'registerIndex', 'middleware' => []]
        );
        Router::register(
            'POST',
            '/register',
            ['controller' => LoginController::class, 'action' => 'register', 'middleware' => []]
        );

        Router::register(
            'GET',
            '/',
            ['controller' => HomeController::class, 'action' => 'index', 'middleware' => []]
        );
    }
}