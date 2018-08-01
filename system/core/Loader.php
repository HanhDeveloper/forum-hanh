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
     * load model
     * It assumes the model's constructor doesn't need parameters for constructor
     *
     * @param string $model class name
     * @return Model
     */
    public function model($model)
    {
        $uc_model = ucwords($model);
        if (! class_exists($model))
            throw new \RuntimeException("Class not found: $model");

        return $this->{$model} = new $uc_model();
    }

    /**
     * Request class
     */
    public function request()
    {
        static $request;
        if ($request === NULL)
            $request = new Request();
        return $request;
    }

    /**
     * Response class
     */
    public function response()
    {
        static $response;
        if ($response === NULL)
            $response = new Response();
        return $response;
    }

    /**
     * Connect database
     */
    public function database()
    {
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => defined('DB_DRIVER') ? DB_DRIVER : 'mysql',
            'host' => defined('DB_HOST') ? DB_HOST : 'localhost',
            'database' => defined('DB_NAME') ? DB_NAME : 'demo',
            'username' => defined('DB_USER') ? DB_USER : 'root',
            'password' => defined('DB_PASS') ? DB_PASS : '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        // Setup the Eloquent ORM…
        $capsule->bootEloquent();
    }

    /**
     * Magic accessor for model auto loading.
     *
     * @param  string $name Property name
     * @return object The model instance
     */
    public function __get($name)
    {
        return NULL;
    }
}