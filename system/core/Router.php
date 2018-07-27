<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpMethodNotAllowedException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;
use Phroute\Phroute\RouteCollector;
use RuntimeException;

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
     * @var string
     */
    private $basePath = '';

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
     *
     * @param string $requestMethod
     * @param string $requestUrl
     */
    public function match($requestMethod = null, $requestUrl = null)
    {
        //NB. You can cache the return value from $router->getData() so you don't have to create the routes each request - massive speed gains
        $this->dispatcher = new Dispatcher($this->getData());
        $requestMethod = $requestMethod == null ? $_SERVER['REQUEST_METHOD'] : $requestMethod;
        $requestUrl = $requestUrl == null ? $_SERVER['REQUEST_URI'] : $requestUrl;
        $requestUri = str_replace($this->basePath, '', parse_url($requestUrl, PHP_URL_PATH));
        try {
            $this->dispatcher->dispatch($requestMethod, $requestUri);
        } catch (HttpRouteNotFoundException $e) {
            print $e->getMessage();
        } catch (HttpMethodNotAllowedException $e) {
            print $e->getMessage();
        }
    }


    /**
     * Magic assessor for Router auto loading.
     *
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (method_exists($this, $name))
            return call_user_func_array(array($this, $name), $args);
        elseif (method_exists($this->dispatcher, $name))
            return call_user_func_array(array($this->dispatcher, $name), $args);
        else
            throw new RuntimeException("Does not have a method: $name");
    }
}