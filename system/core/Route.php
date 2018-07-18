<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace core;

use Exception;

/**
 * Class Route
 * @package core
 */
class Route
{
    /**
     * URL of this Route
     * @var string
     */
    private $url;

    /**
     * Accepted HTTP methods for this route.
     * @var string[]
     */
    private $methods;

    /**
     * Target for this route, can be anything.
     * @var mixed
     */
    private $target;

    /**
     * The name of this route, used for reversed routing
     * @var string
     */
    private $name;

    /**
     * Custom parameter filters for this route
     * @var array
     */
    private $filters = array();

    /**
     * Array containing parameters passed through request URL
     * @var array
     */
    private $parameters = array();

    /**
     * Set named parameters to target method
     * @example [ [0] => [ ["link_id"] => "12312" ] ]
     * @var bool
     */
    private $parametersByName;

    /**
     * @param       $resource
     * @param array $config
     */
    public function __construct($resource, array $config)
    {
        $this->url = $resource;
        $this->methods = isset($config['methods']) ? (array)$config['methods'] : array();
        $this->target = isset($config['target']) ? $config['target'] : null;
        $this->name = isset($config['name']) ? $config['name'] : null;
        $this->parameters = isset($config['parameters']) ? $config['parameters'] : array();
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $url = (string)$url;

        // make sure that the URL is suffixed with a forward slash
        if (substr($url, -1) !== '/') {
            $url .= '/';
        }

        $this->url = $url;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;
    }

    public function getMethods()
    {
        return $this->methods;
    }

    public function setMethods(array $methods)
    {
        $this->methods = $methods;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string)$name;
    }

    public function setFilters(array $filters, $parametersByName = false)
    {
        $this->filters = $filters;
        $this->parametersByName = $parametersByName;
    }

    public function getRegex()
    {
        return preg_replace_callback('/(:\w+)/', array(&$this, 'substituteFilter'), $this->url);
    }

    private function substituteFilter($matches)
    {
        if (isset($matches[1], $this->filters[$matches[1]])) {
            return $this->filters[$matches[1]];
        }

        return '([\w-%]+)';
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Processing Requests
     * @throws Exception
     */
    public function dispatch()
    {
        if ($this->parametersByName) {
            $this->parameters = array($this->parameters);
        }

        if (is_callable($this->target)) {
            call_user_func_array($this->target, $this->parameters);
        } else {

            $action = explode('::', $this->target);

            if (! class_exists($action[0]))
                throw new Exception("Not Found Class $action[0]");

            $instance = new $action[0];

            if (empty($action[1]) || trim($action[1]) === '') {
                call_user_func_array($instance, $this->parameters);
                return;
            }

            call_user_func_array(array($instance, $action[1]), $this->parameters);
        }
    }
}