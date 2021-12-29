<?php

namespace Amdrija\RealEstate\Framework;

use Amdrija\RealEstate\Framework\Responses\HTMLResponse;

/**
 * Class Controllers
 *
 * @package Andrijaj\DemoProject\Framework
 */
abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    /**
     * Returns the request.
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Returns the HTMLResponse that was built with the specified $layout, $view and $variables.
     * @param string $layout
     * @param string $view
     * @param array $variables
     * @return HTMLResponse
     */
    protected function buildHtmlResponseLayout(string $layout, string $view, array $variables = []): HTMLResponse
    {
        $response = new HTMLResponse($view, $variables);
        $response->setLayout($layout);

        return $response;
    }

    /**
     * Returns true if the provided string contains URL reserved characters or whitespace.
     * @param string $string
     * @return bool
     */
    protected function stringContainsURLReservedCharactersOrSpaces(string $string): bool
    {
        return preg_match("/[!*'();:@&=+$,\/?#\[\]\s]/", $string);
    }
}