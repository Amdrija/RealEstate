<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Application\RequestModels\Pagination;
use Amdrija\RealEstate\Application\Services\UserService;
use Amdrija\RealEstate\Framework\ArraySerializer;
use Amdrija\RealEstate\Framework\Responses\Response;
use Illuminate\Support\Arr;

class AdminController extends FrontController
{
    private readonly UserService $userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function userList(): Response
    {
        return $this->buildHtmlResponse('userList',
            ['title' => 'User list',
                'paginatedResponse' => $this->userService->listUsers($this->request->getQueryParameters())]);
    }
}