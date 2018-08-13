<?php
/**
 * Hanh Developer
 *
 * @package     HDev
 * @author      Hanh <hanh.cho.do@gmail.com>
 * @copyright   2018 by Hanh Developer
 * @link        https://fb.com/hnv.97
 * @filesource
 */

namespace HDev\Router;

use HDev\HTTP\Request;
use HDev\HTTP\Response;
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\HandlerResolverInterface;
use Phroute\Phroute\RouteDataInterface;

class Router extends Dispatcher
{
    /**
     * The base REQUEST_URI.
     *
     * @var string
     */
    private $basePath = '';

    /**
     * Override constructor.
     *
     * @param RouteDataInterface            $data
     * @param HandlerResolverInterface|null $resolver
     * @param Request                       $request
     * @param Response                      $response
     */
    public function __construct(RouteDataInterface $data, HandlerResolverInterface $resolver = null, Request $request, Response $response)
    {
        if (is_null($resolver))
            $resolver = new RouterResolver($request, $response);
        parent::__construct($data, $resolver);
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
        $requestMethod = $requestMethod ?? $_SERVER['REQUEST_METHOD'];
        $requestUrl = parse_url($requestUrl ?? $_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = str_replace($this->basePath, '', $requestUrl);
        return $this->dispatch($requestMethod, $requestUri);
    }
}