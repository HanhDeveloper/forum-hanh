<?php
/**
 * Hanh Developer
 *
 * @package     HDev
 * @author      Hanh <hanh.cho.do@gmail.com>
 * @copyright   2018 by Hanh Developer
 * @link        https://fb.com/hnv.97
 * @filesource
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