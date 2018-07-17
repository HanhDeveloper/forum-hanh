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
    public $request = null;

    /**
     * @var Response
     */
    public $response = null;

    /**
     * @var Router
     */
    private $router = null;

    /**
     * App constructor.
     */
    public function __construct()
    {
        // initialize request and response objects
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router();
    }

    /**
     * Run the application.
     */
    public function run()
    {

        // set subdirectory
        $this->router->setBasePath('/hanh-dev');

        try {

            // simple routers
            $this->routing();

            // Match a given Request Url against stored routes
            $match = $this->router->match();

            // call closure or throw 404 status
            if ($match && is_callable($match['target'])) {
                call_user_func_array($match['target'], $match['params']);
            } else {
                // no route was matched
                throw new Exception('404 Not Found');
            }
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
        $this->router->map('GET|POST', '/users/[i:id]/', function ($id) {
            echo("sàdsafdsafsdf $id");
        });
    }
}