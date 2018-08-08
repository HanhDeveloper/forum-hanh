<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

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
        $this->router->setBasePath('/hanh-dev');
    }

    /**
     * Run the application.
     */
    public function run()
    {
        try {
            $this->router->start();
        } catch (\Exception $e) {
            if (LOG_MODE) Logger::log($e->getMessage());
            print $e;
        }
    }
}