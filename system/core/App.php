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
     * The current version of Framework
     */
    const VERSION = '1.0-dev';

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Loader
     */
    private $load;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->load = new Loader();
    }

    /**
     * Run the application.
     */
    public function run()
    {
        try {
            $this->initRouter();
            return $this->handleRequest($this->router);
        } catch (\Exception $e) {
            if (LOG_MODE) Logger::log($e->getMessage());
            print $e;
        }
    }

    /**
     * Handles the main request logic and fires the controller.
     *
     * @param Router $router
     * @param bool   $return
     * @return mixed|null
     */
    private function handleRequest(Router $router, bool $return = false)
    {
        // Initialize request, response objects
        $this->request = $this->load->request();
        $this->response = $this->load->response();
        $router->output();

    }

    private function initRouter()
    {
        $router = new Router();
        $router->init($this->load);
        $router->setBasePath('/hanh-dev');
        $this->router = $router;
    }
}