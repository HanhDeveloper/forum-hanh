<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

use Exception;

/**
 * Class App
 * @package Core
 */
class App
{
    /**
     * @var Request
     */
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Router
     */
    private $router;

    /**
     * App constructor.
     */
    public function __construct()
    {
        // initialize request and response, router objects
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
    }

    /**
     * Run the application.
     */
    public function run()
    {
        // set sub-directory
        $this->router->setBasePath('/hanh-dev/');

        try {
            // simple routers
            $this->routing();

            // Match a given Request Url against stored routes
            $match = $this->router->match();

            // no route was matched then throw 404 status
            if (! $match)
                throw new Exception('404 Not Found');

        } catch (Exception $e) {
            Logger::log($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    private function routing()
    {
        // map homepage
        $this->router->map('GET', '/', function () {
            echo("sàdsafdsafsdf");
        });

        // map users details page
        $this->router->map('GET', '/users/[i:id]/', function ($id) {
            echo("sàdsafdsafsdf $id");
        });
    }
}