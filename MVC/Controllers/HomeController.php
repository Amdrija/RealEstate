<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Framework\Responses\Response;

class HomeController extends FrontController
{
    public function index(): Response
    {
        return $this->buildHtmlResponse('landingPage', ['title' => 'Estate']);
    }
}