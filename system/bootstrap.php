<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Autoload
|--------------------------------------------------------------------------
|
| After running "composer install", we can use the autoloader file created.
|
*/

require '../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Common
|--------------------------------------------------------------------------
*/

require 'Common.php';

/*
|--------------------------------------------------------------------------
| Register Error & Exception handlers
|--------------------------------------------------------------------------
|
| Here we will register the methods that will fire whenever there is an error
| or an exception has been thrown.
|
*/

//\core\Handler::register();

/*
|--------------------------------------------------------------------------
| Start Session
|--------------------------------------------------------------------------
|
*/

\Core\Session::init();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will create the application instance which will take care of routing
| the incoming request to the corresponding controller and action method if valid
|
*/

$app = new \Core\App();

return $app;