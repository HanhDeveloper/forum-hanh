<?php
/**
 * @package      HDev
 * @author       Hanh <hanh.cho.do@gmail.com>
 * @copyright    2018 by Hanh Developer
 * @link         https://fb.com/hnv.97
 */

/*
|--------------------------------------------------------------------------
| Define Application Configuration Constants
|--------------------------------------------------------------------------
|
| PUBLIC_ROOT: 	the root URL for the application (see below).
| BASE_DIR: 	path to the directory that has all of your "app", "public", "vendor", ... directories.
| IMAGES:		path to upload images, don't use it for displaying images, use Config::get('root') . "/img/" instead.
| APP:			path to app directory.
|
*/

//define('BASE_DIR', __DIR__ . DIRECTORY_SEPARATOR);
define('BASE_DIR', str_replace("\\", "/", dirname(__DIR__)));

/*
 |---------------------------------------------------------------
 | BOOTSTRAP THE APPLICATION
 |---------------------------------------------------------------
 | This process sets up the path constants
 | Loads and registers autoloader with Composer's.
 */

$app = require '../system/bootstrap.php';

/*
 |---------------------------------------------------------------
 | LAUNCH THE APPLICATION
 |---------------------------------------------------------------
 */

$app->run();