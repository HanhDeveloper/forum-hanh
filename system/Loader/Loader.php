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

namespace HDev\Loader;

use HDev\HTTP\Request;
use HDev\HTTP\Response;
use Illuminate\Database\Capsule\Manager as Capsule;

class Loader
{
    /**
     * @var array
     */
    private $_classes = [];

    /**
     * Request class
     */
    public function request()
    {
        static $request;
        return $request ?? $request = new Request();
    }

    /**
     * Response class
     */
    public function response()
    {
        static $response;
        return $response ?? $response = new Response();
    }

    /**
     * @param $class
     * @return false|int|string
     */
    private function isLoaded($class)
    {
        return array_search($this->_classes, $class, true);
    }

    /**
     *
     */
    private function load($class)
    {
        static $_classes;

        if (($class = $this->isLoaded($class)) === false)
            $_classes[$class] = new $class;

        return $this->_classes[$class];
    }

    public function loadLibrary($class)
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