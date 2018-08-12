<?php
/**
 * @package      HDev
 * @author       Hanh <hanh.cho.do@gmail.com>
 * @copyright    2018 by Hanh Developer
 * @link         https://fb.com/hnv.97
 */

namespace HDev\Router;

use HDev\HTTP\Request;
use HDev\HTTP\Response;
use Phroute\Phroute\HandlerResolverInterface;

class RouterResolver implements HandlerResolverInterface
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Create an instance of the given handler.
     *
     * @param $handler
     * @return array
     */
    public function resolve($handler)
    {
        if (is_array($handler) and is_string($handler[0])) {
            $handler[0] = new $handler[0];
            $handler[0]->initController($this->request, $this->response);
        }

        return $handler;
    }
}