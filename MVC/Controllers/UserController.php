<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\RequestModels\Pagination;
use Amdrija\RealEstate\Application\Services\AgencyService;
use Amdrija\RealEstate\Application\Services\CityService;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Amdrija\RealEstate\Framework\Responses\Response;
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
        $id = $parameters['id'];
        return $this->buildHtmlResponse('user',
            ['title' => 'User',
                'user' => $this->userService->getUserById($id),
                'cities' => $this->cityService->getCitiesForSelect(),
                'agencies' => $this->agencyService->getAgenciesForSelect()]);
    }
}