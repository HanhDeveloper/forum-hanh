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
    protected $load;

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
        $this->load = new Loader();
        $this->request = $this->load->request();
        $this->response = $this->load->response();
        $this->view = new View($this->request, $this->response);
        $this->load->database();
    }

    /**
     * Display to user browser
     */
    public function __destruct()
    {
        $this->response->send();
    }
}