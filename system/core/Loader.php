<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace core;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Loader
 * @package core
 */
class Loader
{
    /**
     * @var array
     */
    private $_classes = array();

    /**
     * Request class
     */
    public function request()
    {
        static $request;
        is_object($request) or $request = new Request();
        return $request;
    }

    /**
     * Response class
     */
    public function response()
    {
        static $response;
        is_object($response) or $response = new Response();
        return $response;
    }

    /**
     * View class
     */
    public function view()
    {
        return new View($this);
    }

    /**
     * @param $class
     * @return false|int|string
     */
    private function is_loaded($class)
    {
        return array_search($this->_classes, $class, TRUE);
    }

    /**
     *
     */
    private function load($class)
    {
        static $_classes;

        if (($class = $this->is_loaded($class)) === FALSE)
            $_classes[$class] = new $class;

        return $this->_classes[$class];
    }

    public function load_library($class)
    {
        $this->load($class);
    }

    /**
     * Connect database
     */
    public function database()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver'    => defined('DB_DRIVER') ? DB_DRIVER : 'mysql',
            'host'      => defined('DB_HOST') ? DB_HOST : 'localhost',
            'database'  => defined('DB_NAME') ? DB_NAME : 'demo',
            'username'  => defined('DB_USER') ? DB_USER : 'root',
            'password'  => defined('DB_PASS') ? DB_PASS : '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
        $capsule->setAsGlobal();
        // Setup the Eloquent ORM…
        $capsule->bootEloquent();
    }
}