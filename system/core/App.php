<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

use RuntimeException;

/**
 * Class App
 * @package Core
 */
class App
{
    /**
     * @var Router
     */
    private $router;

    /**
     * App constructor.
     */
    public function __construct()
    {
        // initialize the router object
        $this->router = new Router();
    }

    /**
     * Run the application.
     */
    public function run()
    {
        try {
            // simple routers
            $this->getRoutes();
            $this->router->setBasePath('/hanh-dev');
            $this->router->match();
        } catch (RuntimeException $e) {
            print $e->getMessage();
            Logger::log($e->getMessage());
        }
    }

    private function getRoutes()
    {
        $this->router->any('/', function () {
            echo 'This responds to the default route';
        });
        $this->router->controller('/controller', 'Hanh\\Hanh');
        $this->router->controller('/chat', 'Hanh\\Chat');
    }
}