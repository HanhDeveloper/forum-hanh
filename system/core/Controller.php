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
        // Initialize the required objects and starts up it
        $this->load = new Loader();
        $this->request = $this->load->request();
        $this->response = $this->load->response();
        $this->view = $this->load->view();
        $this->load->database();
    }

    /**
     * Sends response to the browser.
     */
    public function __destruct()
    {
        $this->response->send();
    }
}