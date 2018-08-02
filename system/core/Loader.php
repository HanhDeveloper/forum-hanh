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
     * Request class
     */
    public function request()
    {
        static $request;
        return $request ? $request : new Request();
    }

    /**
     * Response class
     */
    public function response()
    {
        static $response;
        return $response ? new Response() : $response;
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
        // Setup the Eloquent ORM…
        $capsule->bootEloquent();
    }
}