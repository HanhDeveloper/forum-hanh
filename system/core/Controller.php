<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class Controller
 * @package Core
 */
class Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;


    /**
     * @var Loader
     */
    protected $loader;

    /**
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        // initialization of the required object
        $this->request = new Request();
        $this->response = new Response();
        $this->loader = new Loader();
        $this->loader->database();
        $this->view = new View($this->request, $this->response);
    }

    /**
     * Show to browser
     */
    public function __destruct()
    {
        $this->response->send();
    }
}