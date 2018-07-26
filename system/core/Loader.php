<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace core;

use RuntimeException;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Loader
 * @package core
 */
class Loader
{

    /**
     *
     * Magic accessor for model auto loading.
     *
     * @param  string $name Property name
     * @return object The model instance
     */
    public function __get($name)
    {
        return null;
    }

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
            throw new RuntimeException("Class not found: $model");

        return $this->{$model} = new $uc_model();
    }

    /**
     * Connect database
     */
    public function database()
    {
        defined("DB_DRIVER") or define('DB_DRIVER', 'mysql');
        defined("DB_HOST") or define('DB_HOST', 'localhost');
        defined("DB_NAME") or define('DB_NAME', 'demo');
        defined("DB_USER") or define('DB_USER', 'root');
        defined("DB_PASS") or define('DB_PASS', '');
        $capsule = new Capsule;
        $capsule->addConnection([
            'driver' => DB_DRIVER,
            'host' => DB_HOST,
            'database' => DB_NAME,
            'username' => DB_USER,
            'password' => DB_PASS,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        // Setup the Eloquent ORM…
        $capsule->bootEloquent();
    }
}