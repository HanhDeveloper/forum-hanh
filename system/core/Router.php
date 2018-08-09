<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\RouteCollector;

/**
 * Class Router
 * @package core
 */
class Router extends RouteCollector
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * The base REQUEST_URI.
     *
     * @var string
     */
    private $basePath = '';

    /**
     * @var Loader
     */
    private $loader;

    /**
     * Initializer.
     */
    public function init(Loader $loader)
    {
        $this->loader = $loader;
        $this->getRoutes();
    }

    /**
     * Set the base path to ignore leading part of the Request URL (if main file lives in subdirectory of host)
     * Useful if you are running your application from a subdirectory.
     *
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Match a given Request Url against stored routes
     * Dispatch a route for the given HTTP Method / URI.
     *
     * @param string $requestMethod
     * @param string $requestUrl
     * @return mixed|null
     */
    public function output(string $requestMethod = null, string $requestUrl = null)
    {
        //NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
        $this->dispatcher = new Dispatcher($this->getData(), new RouterResolver($this->loader));
        $requestMethod = $requestMethod ?? $_SERVER['REQUEST_METHOD'];
        $requestUrl = parse_url($requestUrl ?? $_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace($this->basePath, '', $requestUrl);
        return $this->dispatcher->dispatch($requestMethod, $requestUri);
    }

    /**
     * This registers the route to the store.
     */
    private function getRoutes()
    {
        $this->controller('/', 'Hanh\\Chat');
        $this->controller('/chat', 'Hanh\\Chat');
    }
}