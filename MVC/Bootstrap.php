<?php

namespace Amdrija\RealEstate\MVC;

use Amdrija\RealEstate\Application\Infrastructure\MySQL\AgencyRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\CityRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\UserRepository;
use Amdrija\RealEstate\Application\Interfaces\IAgencyRepository;
use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Services\AgencyService;
use Amdrija\RealEstate\Application\Services\CityService;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\DependencyInjectionContainer;
use Amdrija\RealEstate\Framework\Router;
use Amdrija\RealEstate\MVC\Controllers\UserController;
use Amdrija\RealEstate\MVC\Controllers\HomeController;
use Amdrija\RealEstate\MVC\Controllers\LoginController;
use Amdrija\RealEstate\MVC\Middleware\AdminMiddleware;
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
        self::initializeRoutes();
        self::RegisterDependencies();
    }

    public static function RegisterDependencies()
    {
        self::RegisterControllers();
        self::RegisterServices();
        self::RegisterRepositories();
        self::RegisterMiddleware();
    }

    public static function RegisterControllers()
    {
        DependencyInjectionContainer::registerClass(LoginController::class);
        DependencyInjectionContainer::registerClass(HomeController::class);
        DependencyInjectionContainer::registerClass(UserController::class);
    }

    public static function RegisterServices()
    {
        DependencyInjectionContainer::registerClass(LoginService::class);
        DependencyInjectionContainer::registerClass(UserService::class);
        DependencyInjectionContainer::registerClass(CityService::class);
        DependencyInjectionContainer::registerClass(AgencyService::class);
    }

    public static function RegisterRepositories()
    {
        DependencyInjectionContainer::register(IUserRepository::class, UserRepository::class);
        DependencyInjectionContainer::register(ICityRepository::class, CityRepository::class);
        DependencyInjectionContainer::register(IAgencyRepository::class, AgencyRepository::class);
    }

    public static function RegisterMiddleware()
    {
        DependencyInjectionContainer::registerClass(AdminMiddleware::class);
    }

    private static function initializeRoutes()
    {
        /* Login routes */
        Router::register(
            'GET',
            '/login',
            ['controller' => LoginController::class, 'action' => 'index', 'middleware' => []]
        );
        Router::register(
            'GET',
            '/logout',
            ['controller' => LoginController::class, 'action' => 'logOut', 'middleware' => []]
        );
        Router::register(
            'POST',
            '/login',
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

    /**
     * Initializes Admin routes.
     * @throws Exception
     */
    private static function initializeAdminRoutes()
    {
        Router::register(
            'GET',
            '/admin/users',
            ['controller' => UserController::class, 'action' => 'userList', 'middleware' => [AdminMiddleware::class]]
        );

        Router::register(
            'GET',
            '/admin/users/{:id}',
            ['controller' => UserController::class, 'action' => 'getUserById', 'middleware' => [AdminMiddleware::class]]
        );
    }
}