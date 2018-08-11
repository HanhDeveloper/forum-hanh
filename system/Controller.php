<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace HDev;

use HDev\HTTP\Request;
use HDev\HTTP\Response;

class Controller
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
     * Constructor.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function initController(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}