<?php

namespace Amdrija\RealEstate\MVC\Controllers;

use Amdrija\RealEstate\Framework\Controller;
use Amdrija\RealEstate\Framework\Responses\HTMLResponse;

class FrontController extends Controller
{
    public function buildHtmlResponse(string $view, array $variables = []): HTMLResponse
    {
        return parent::buildHtmlResponseLayout('layout', $view, $variables);
    }
}