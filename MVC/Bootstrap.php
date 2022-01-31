<?php

namespace Amdrija\RealEstate\MVC;

use Amdrija\RealEstate\Application\Infrastructure\MySQL\AgencyRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\BusLineRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\CityRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\ConditionTypeRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\EstateRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\EstateTypeRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\HeatingTypeRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\MicroLocationRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\PerkRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\StreetRepository;
use Amdrija\RealEstate\Application\Infrastructure\MySQL\UserRepository;
use Amdrija\RealEstate\Application\Interfaces\IAgencyRepository;
use Amdrija\RealEstate\Application\Interfaces\IBusLineRepository;
use Amdrija\RealEstate\Application\Interfaces\ICityRepository;
use Amdrija\RealEstate\Application\Interfaces\IConditionTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IEstateRepository;
use Amdrija\RealEstate\Application\Interfaces\IEstateTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IHeatingTypeRepository;
use Amdrija\RealEstate\Application\Interfaces\IMicroLocationRepository;
use Amdrija\RealEstate\Application\Interfaces\IPerkRepository;
use Amdrija\RealEstate\Application\Interfaces\IStreetRepository;
use Amdrija\RealEstate\Application\Interfaces\IUserRepository;
use Amdrija\RealEstate\Application\Services\AgencyService;
use Amdrija\RealEstate\Application\Services\CityService;
use Amdrija\RealEstate\Application\Services\EstateService;
use Amdrija\RealEstate\Application\Services\LoginService;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\DependencyInjectionContainer;
use Amdrija\RealEstate\Framework\ImageService;
use Amdrija\RealEstate\Framework\Router;
use Amdrija\RealEstate\MVC\Controllers\EstateController;
use Amdrija\RealEstate\MVC\Controllers\MicroLocationController;
use Amdrija\RealEstate\MVC\Controllers\UserController;
use Amdrija\RealEstate\MVC\Controllers\HomeController;
use Amdrija\RealEstate\MVC\Controllers\LoginController;
use Amdrija\RealEstate\MVC\Middleware\AdminMiddleware;
use Amdrija\RealEstate\MVC\Middleware\AuthenticationMiddleware;
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
        DependencyInjectionContainer::registerClass(EstateController::class);
        DependencyInjectionContainer::registerClass(MicroLocationController::class);
    }

    public static function RegisterServices()
    {
        DependencyInjectionContainer::registerClass(LoginService::class);
        DependencyInjectionContainer::registerClass(UserService::class);
        DependencyInjectionContainer::registerClass(CityService::class);
        DependencyInjectionContainer::registerClass(AgencyService::class);
        DependencyInjectionContainer::registerClass(EstateService::class);
        DependencyInjectionContainer::registerClass(ImageService::class);
    }

    public static function RegisterRepositories()
    {
        DependencyInjectionContainer::register(IUserRepository::class, UserRepository::class);
        DependencyInjectionContainer::register(ICityRepository::class, CityRepository::class);
        DependencyInjectionContainer::register(IAgencyRepository::class, AgencyRepository::class);
        DependencyInjectionContainer::register(IEstateRepository::class, EstateRepository::class);
        DependencyInjectionContainer::register(IEstateTypeRepository::class, EstateTypeRepository::class);
        DependencyInjectionContainer::register(IConditionTypeRepository::class, ConditionTypeRepository::class);
        DependencyInjectionContainer::register(IHeatingTypeRepository::class, HeatingTypeRepository::class);
        DependencyInjectionContainer::register(IStreetRepository::class, StreetRepository::class);
        DependencyInjectionContainer::register(IBusLineRepository::class, BusLineRepository::class);
        DependencyInjectionContainer::register(IPerkRepository::class, PerkRepository::class);
        DependencyInjectionContainer::register(IMicroLocationRepository::class, MicroLocationRepository::class);
    }

    public static function RegisterMiddleware()
    {
        DependencyInjectionContainer::registerClass(AdminMiddleware::class);
        DependencyInjectionContainer::registerClass(AuthenticationMiddleware::class);
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

        Router::register(
            'GET',
            '/user/edit',
            ['controller' => UserController::class, 'action' => 'editContactIndex', 'middleware' => [AuthenticationMiddleware::class]]
        );
        Router::register(
        'POST',
        '/user/edit',
            ['controller' => UserController::class, 'action' => 'editContact', 'middleware' => [AuthenticationMiddleware::class]]
        );

        Router::register(
            'GET',
            '/user/edit/password',
            ['controller' => UserController::class, 'action' => 'editPasswordIndex', 'middleware' => [AuthenticationMiddleware::class]]
        );
        Router::register(
        'POST',
        '/user/edit/password',
            ['controller' => UserController::class, 'action' => 'editPassword', 'middleware' => [AuthenticationMiddleware::class]]
        );

        Router::register(
            'GET',
            '/estates/add',
            ['controller' => EstateController::class, 'action' => 'addEstateIndex', 'middleware' => [AuthenticationMiddleware::class]]
        );

        Router::register(
            'POST',
            '/estates/add',
            ['controller' => EstateController::class, 'action' => 'addEstate', 'middleware' => [AuthenticationMiddleware::class]]
        );

        Router::register(
            'GET',
            '/search',
            ['controller' => HomeController::class, 'action' => 'search', 'middleware' => []]
        );

        Router::register(
            'GET',
            '/estates/search/{:id}',
            ['controller' => HomeController::class, 'action' => 'getEstateById', 'middleware' => []]
        );

        Router::register(
            'GET',
            '/estates/userList',
            ['controller' => EstateController::class, 'action' => 'searchByUser', 'middleware' => [AuthenticationMiddleware::class]]
        );

        Router::register(
            'GET',
            '/microLocations',
            ['controller' => MicroLocationController::class, 'action' => 'getList', 'middleware' => []]
        );

        Router::register(
            'GET',
            '/estates/edit/{:id}',
            ['controller' => EstateController::class, 'action' => 'editEstateIndex', 'middleware' => [AuthenticationMiddleware::class]]
        );

        Router::register(
            'POST',
            '/estates/edit/{:id}',
            ['controller' => EstateController::class, 'action' => 'editEstate', 'middleware' => [AuthenticationMiddleware::class]]
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
            '/admin/users/edit/{:id}',
            ['controller' => UserController::class, 'action' => 'getUserById', 'middleware' => [AdminMiddleware::class]]
        );

        Router::register(
            'POST',
            '/admin/users/edit/{:id}',
            ['controller' => UserController::class, 'action' => 'editUser', 'middleware' => [AdminMiddleware::class]]
        );
        Router::register(
            'POST',
            '/admin/users/delete/{:id}',
            ['controller' => UserController::class, 'action' => 'deleteUser', 'middleware' => [AdminMiddleware::class]]
        );

        Router::register(
            'POST',
            '/admin/users/add',
            ['controller' => UserController::class, 'action' => 'addUser', 'middleware' => [AdminMiddleware::class]]
        );


        Router::register(
            'GET',
            '/admin/users/add',
            ['controller' => UserController::class, 'action' => 'addUserIndex', 'middleware' => [AdminMiddleware::class]]
        );
    }
}