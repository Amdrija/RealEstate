<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Amdrija\RealEstate\Framework\Request;
use Amdrija\RealEstate\Framework\Responses\ErrorResponseFactory;
use Amdrija\RealEstate\Framework\Router;
use Amdrija\RealEstate\MVC\Bootstrap;

try {
    Bootstrap::initialize();
    $response = Router::dispatch(new Request());
} catch (Exception $e) {
    $response = ErrorResponseFactory::getResponse($e->getMessage(), 500);
}
http_response_code($response->getStatus());
$response->constructHeader();
echo $response->getContent();