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
    public $request;

    /**
     * @var Response
     */
    public $response;

    /**
     * @var Loader
     */
    protected $load;

    /**
     * @var View
     */
    protected $view;

    /**
     * Initialize the required objects and starts up it
     *
     * @param Loader $loader
     */
    public function init(Loader $loader)
    {
        $this->load = $loader;
        $this->request = $this->load->request();
        $this->response = $this->load->response();
        $this->view = new View($this);
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