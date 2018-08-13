<?php
/**
 * @package      HDev
 * @author       Hanh <hanh.cho.do@gmail.com>
 * @copyright    2018 by Hanh Developer
 * @link         https://fb.com/hnv.97
 */

namespace HDev\Config;

class BaseService
{
    /**
     * Cache for instance of any services that
     * have been requested as a "shared" instance.
     *
     * @var array
     */
    protected static $instances = [];

    /**
     * Mock objects for testing which are returned if exist.
     *
     * @var array
     */
    protected static $mocks = [];

    /**
     * Returns a shared instance of any of the class' services.
     *
     * $key must be a name matching a service.
     *
     * @param string $key
     * @param array  ...$params
     *
     * @return mixed
     */
    protected static function getSharedInstance(string $key, ...$params)
    {
        // Returns mock if exists
        if (isset(static::$mocks[$key])) {
            return static::$mocks[$key];
        }
        if (! isset(static::$instances[$key])) {
            // Make sure $getShared is false
            array_push($params, false);
            static::$instances[$key] = static::$key(...$params);
        }
        return static::$instances[$key];
    }

    /**
     * Provides the ability to perform case-insensitive calling of service
     * names.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        $name = strtolower($name);
        if (method_exists(__CLASS__, $name)) {
            return Services::$name(...$arguments);
        }
    }

    /**
     * Inject mock object for testing.
     *
     * @param string $name
     * @param        $mock
     */
    public static function injectMock(string $name, $mock)
    {
        $name = strtolower($name);
        static::$mocks[$name] = $mock;
    }
}