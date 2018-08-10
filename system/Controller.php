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
     * @var View
     */
    protected $view;

    /**
     * Initialize the required objects and starts up it
     *
     * @param Request  $request
     * @param Response $response
     */
    public function initController(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->view = new View($this);
    }
}