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
        // set sub-directory
        $this->router->setBasePath('/hanh-dev/');

        try {
            // simple routers
            $this->routing();

            // Match a given Request Url against stored routes
            $match = $this->router->match();

            // no route was matched then throw 404 status
            if ($match === false)
                throw new RuntimeException('404 Not Found');

        } catch (RuntimeException $e) {
            print $e->getMessage();
            Logger::log($e->getMessage());
        }
    }

    private function routing()
    {
        // map homepage
        $this->router->map('GET', '/', '\Hanh\Hanh::index');

        // map users details page
        $this->router->map('GET', '/users/[i:id]', '\Hanh\Hanh::index');
    }
}