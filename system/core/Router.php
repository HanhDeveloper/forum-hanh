<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class Router
 * @package core
 */
class Router
{
    /**
     * Array of all Route objects.
     * @var Route[]
     */
    private $routes = array();

    /**
     * The base REQUEST_URI. Gets prepended to all route url's.
     * @var string
     */
    private $basePath = '';

    /**
     * Array of default match types (regex helpers)
     * @var array
     */
    private $matchTypes = array(
        'i' => '[0-9]++',
        's' => '[0-9A-Za-z]++',
        '*' => '.+?',
        '**' => '.++',
        '' => '[^/\.]++'
    );

    /**
     * Create router in one call from config.
     *
     * @param array  $routes
     * @param string $basePath
     * @param array  $matchTypes
     */
    public function __construct($routes = array(), $basePath = '', $matchTypes = array())
    {
        $this->addRoutes($routes);
        $this->setBasePath($basePath);
        $this->addMatchTypes($matchTypes);
    }

    /**
     * Add multiple routes at once from array in the following format:
     *
     *   $routes = array(
     *      array($method, $route, $target, $name)
     *   );
     *
     * @param array $routes
     * @return void
     */
    public function addRoutes(array $routes)
    {
        foreach ($routes as $route) {
            call_user_func_array(array($this, 'map'), $route);
        }
    }

    /**
     * Retrieves all routes.
     *
     * Useful if you want to process or display routes.
     * @return array All routes.
     */
    public function getRoutes()
    {
        return $this->routes;
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
     * Add named match types. It uses array_merge so keys can be overwritten.
     *
     * @param array $matchTypes The key is the name and the value is the regex.
     */
    public function addMatchTypes($matchTypes)
    {
        $this->matchTypes = array_merge($this->matchTypes, $matchTypes);
    }

    /**
     * Map a route to a target
     *
     * @param string $method One of 5 HTTP Methods, or a pipe-separated list of multiple HTTP Methods (GET|POST|PATCH|PUT|DELETE)
     * @param string $route  The route regex, custom regex must start with an @. You can use multiple pre-set regex filters, like [i:id]
     * @param mixed  $target The target where this route should point to. Can be anything.
     * @param string $name   Optional name of this route. Supply if you want to reverse route this url in your application.
     */
    public function map($method, $route, $target, $name = null)
    {
        $this->routes[] = new Route($route, ['methods' => $method, 'target' => $target, 'name' => $name]);
    }

    /**
     * Match a given Request Url against stored routes
     *
     * @param string $requestUrl
     * @param string $requestMethod
     * @return boolean true on success, false on failure (no match).
     */
    public function match($requestUrl = null, $requestMethod = null)
    {
        $params = array();

        // set Request Url if it isn't passed as parameter
        if ($requestUrl === null)
            $requestUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

        // strip base path from request url
        $requestUrl = substr($requestUrl, strlen(trim($this->basePath, '/')) + 1);

        // Strip query string (?a=b) from Request Url
        if (($strpos = strpos($requestUrl, '?')) !== false)
            $requestUrl = substr($requestUrl, 0, $strpos);

        $requestUrl = rtrim($requestUrl, '/');

        // set Request Method if it isn't passed as a parameter
        if ($requestMethod === null)
            $requestMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

        foreach ($this->getRoutes() as $route) {

            // compare server request method with route's allowed http methods
            if (! in_array($requestMethod, (array)$route->getMethods(), true)) continue;

            if ($route->getUrl() === '*') { // * wildcard (matches all)
                $match = true;
            } else {
                $regex = $this->compileRoute($route->getUrl());
                $match = preg_match($regex, $requestUrl, $params) === 1;
            }

            if ($match) {
                if ($params) {
                    foreach ($params as $key => $value) {
                        if (is_numeric($key)) unset($params[$key]);
                    }
                }
                $route->setParameters($params);
                $route->dispatch();
                return true;
            }
        }
        return false;
    }

    /**
     * Compile the regex for a given route (EXPENSIVE)
     *
     * @param string $route The route given from stored routes
     * @return string The route compiled
     */
    private function compileRoute($route)
    {
        $route = rtrim($route, '/');
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            $matchTypes = $this->matchTypes;
            foreach ($matches as $match) {
                list($block, $pre, $type, $param, $optional) = $match;
                if (isset($matchTypes[$type])) {
                    $type = $matchTypes[$type];
                }
                if ($pre === '.') {
                    $pre = '\.';
                }
                $optional = $optional !== '' ? '?' : null;

                //Older versions of PCRE require the 'P' in (?P<named>)
                $pattern = '(?:'
                    . ($pre !== '' ? $pre : null)
                    . '('
                    . ($param !== '' ? "?P<$param>" : null)
                    . $type
                    . ')'
                    . $optional
                    . ')'
                    . $optional;
                $route = str_replace($block, $pattern, $route);
            }
        }
        return "`^$route$`u";
    }
}