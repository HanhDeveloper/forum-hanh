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

namespace HDev;

use HDev\Config\Services;
use HDev\HTTP\Request;
use HDev\HTTP\Response;
use HDev\Loader\Loader;
use HDev\Log\Logger;
use HDev\Router\Router;
use Illuminate\Database\Capsule\Manager;

class App
{
    /**
     * The current version of Framework
     */
    const VERSION = '1.0-dev';

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->request = Services::request();
        $this->response = Services::response();
    }

    /**
     * Run the application.
     */
    public function run()
    {
        try {
            $router = $this->initRouter();
            return $this->handleRequest($router);
        } catch (\Exception $e) {
            if (LOG_MODE) Logger::log($e->getMessage());
            print $e->getMessage();
        }
    }

    /**
     * Handles the main request logic and fires the controller.
     *
     * @param Router $router
     * @param bool   $return
     *
     * @return mixed|null
     */
    private function handleRequest(Router $router, bool $return = false)
    {
        $this->database();
        /**
         * @var \HDev\View\Entity
         */
        $entity = $router->output();
        $this->response->setContentType($entity->getType());
        $this->response->setBody($entity);
        // Sends response to the browser.
        $this->response->send();
    }

    /**
     * Connect database
     */
    public function database()
    {
        $capsule = new Manager();
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

    /**
     * @return Router|\Phroute\Phroute\RouteCollector
     */
    private function initRouter()
    {
        $router = new \Phroute\Phroute\RouteCollector();
        $router->controller('/', 'Hanh\\Chat');
        $router->controller('/chat', 'Hanh\\Chat');
        $router = new Router($router->getData(), null, $this->request, $this->response);
        $router->setBasePath('/forum-hanh');
        return $router;
    }
}