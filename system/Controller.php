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

use HDev\HTTP\RequestInterface;
use HDev\HTTP\ResponseInterface;

class Controller
{
    /**
     * @var HTTP\Request
     */
    public $request;

    /**
     * @var HTTP\Response
     */
    public $response;

    /**
     * Constructor.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     */
    public function initController(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}