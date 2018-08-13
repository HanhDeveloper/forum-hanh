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

use HDev\HTTP\Request;
use HDev\HTTP\Response;
use HDev\Loader\Loader;
use HDev\Log\Logger;
use HDev\Router\Router;

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
     * @var Loader
     */
    private $load;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->load = new Loader();
        $this->request = $this->load->request();
        $this->response = $this->load->response();
        $this->load->database();
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
     * @return mixed|null
     */
    private function handleRequest(Router $router, bool $return = false)
    {
        $this->response->setBody($router->output()->getOutput());
        // Sends response to the browser.
        $this->response->send();
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
        $router->setBasePath('/hanh-dev');
        return $router;
    }
}