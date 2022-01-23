<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\RequestModels\Pagination;
use Amdrija\RealEstate\Application\RequestModels\User\EditUser;
use Amdrija\RealEstate\Application\RequestModels\User\EditUserContact;
use Amdrija\RealEstate\Application\RequestModels\User\RegisterUser;
use Amdrija\RealEstate\Application\Services\AgencyService;
use Amdrija\RealEstate\Application\Services\CityService;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Responses\RedirectResponse;
use Amdrija\RealEstate\Framework\Responses\Response;
use Exception;
use Illuminate\Support\Arr;

class UserController extends FrontController
{
    private readonly UserService $userService;
    private readonly CityService $cityService;
    private readonly AgencyService $agencyService;

    public function __construct(UserService $userService, CityService $cityService, AgencyService $agencyService)
    {
        parent::__construct();
        $this->userService = $userService;
        $this->cityService = $cityService;
        $this->agencyService = $agencyService;
    }

    public function userList(): Response
    {
        return $this->buildHtmlResponse('userList',
            ['title' => 'User list',
                'paginatedResponse' => $this->userService->listUsers($this->request->getQueryParameters())]);
    }

    public function getUserById(array $parameters): Response
    {
        $user = $this->userService->getUserById($parameters['id']);
        if (is_null($user)) {
            return ErrorResponseFactory::getResponse("User not found.", 404);
        }

        return $this->buildHtmlResponse('user',
            ['title' => 'User',
                'user' => $user,
                'cities' => $this->cityService->getCitiesForSelect(),
                'agencies' => $this->agencyService->getAgenciesForSelect()]);
    }

    public function addUserIndex(): Response
    {
        return $this->buildHtmlResponse("addUser", ['title' => 'Add User',
            'cities' => $this->cityService->getCitiesForSelect(),
            'agencies' => $this->agencyService->getAgenciesForSelect()]);
    }

    public function addUser(): Response
    {
        $isAdministrator = isset($this->request->getBody()['isAdministrator']);
        $verified = isset($this->request->getBody()['verified']);
        try {
            $user = $this->userService->registerUser($this->request->deseralizeBody(RegisterUser::class), $isAdministrator, $verified);
        } catch (Exception $exception) {
            return $this->buildHtmlResponse('user',
                ['title' => 'Register',
                    'cities' => $this->cityService->getCitiesForSelect(),
                    'agencies' => $this->agencyService->getAgenciesForSelect(),
                    'error' => $exception->getMessage()]
            );
        }

        return new RedirectResponse("/admin/users/edit/{$user->id}");
    }

    public function editUser(array $parameters): Response
    {
        $oldUser = $this->userService->getUserById($parameters['id']);
        if (is_null($oldUser)) {
            return ErrorResponseFactory::getResponse("User not found.", 404);
        }
        try {
            $user = $this->userService->editUser($this->request->deseralizeBody(EditUser::class), $oldUser);
        } catch (Exception $exception) {
            return $this->buildHtmlResponse('user',
                ['title' => 'User',
                    'cities' => $this->cityService->getCitiesForSelect(),
                    'agencies' => $this->agencyService->getAgenciesForSelect(),
                    'error' => $exception->getMessage(),
                    'user' => $oldUser]
            );
        }

        return $this->buildHtmlResponse('user',
            ['title' => 'User',
                'user' => $user,
                'cities' => $this->cityService->getCitiesForSelect(),
                'agencies' => $this->agencyService->getAgenciesForSelect()]);
    }

    public function deleteUser(array $parameters): Response
    {
        $user = $this->userService->getUserById($parameters['id']);
        if (is_null($user)) {
            return ErrorResponseFactory::getResponse("User not found.", 404);
        }

        $this->userService->deleteUser($user);
        return new RedirectResponse("/admin/users");
    }

    public function editContactIndex(): Response
    {
        return $this->buildHtmlResponse("editUserContact", ['title' => 'Edit Contact',
            'user' => $this->userService->getUserById($_SESSION['userId']),
            'cities' => $this->cityService->getCitiesForSelect(),
            'agencies' => $this->agencyService->getAgenciesForSelect()]);
    }

    public function editContact(): Response
    {
        $oldUser = $this->userService->getUserById($_SESSION['userId']);
        if (is_null($oldUser)) {
            return ErrorResponseFactory::getResponse("User not found.", 404);
        }
        try {
            $user = $this->userService->editUserContact($this->request->deseralizeBody(EditUserContact::class), $oldUser);
        } catch (Exception $exception) {
            return $this->buildHtmlResponse('editUserContact',
                ['title' => 'User',
                    'cities' => $this->cityService->getCitiesForSelect(),
                    'agencies' => $this->agencyService->getAgenciesForSelect(),
                    'error' => $exception->getMessage(),
                    'user' => $oldUser]
            );
        }

        return $this->buildHtmlResponse('editUserContact',
            ['title' => 'User',
                'user' => $user,
                'cities' => $this->cityService->getCitiesForSelect(),
                'agencies' => $this->agencyService->getAgenciesForSelect()]);
    }
}