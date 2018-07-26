<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

use RuntimeException;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * View constructor.
     * @param Request  $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        // initialization of the required object
        $this->request = $request;
        $this->response = $response;
        $loader = new Twig_Loader_Filesystem(BASE_DIR . '/views');
        $this->twig = new Twig_Environment($loader);
    }

    /**
     * Override render template method.
     *
     * @param string $name
     * @param array  $context
     */
    public function render($name, array $context = array())
    {
        $name .= '.html';
        $template = call_user_func_array(array($this->twig, 'render'), array($name, $context));
        $this->response->setContent($template);
    }

    /**
     * Magic assessor for Twig auto loading.
     *
     * @param $name
     * @param $args
     * @return mixed
     */
    public function __call($name, $args)
    {
        if (! method_exists($this->twig, $name))
            throw new RuntimeException("Does not have a method: $name");

        return call_user_func_array(array($this->twig, $name), $args);
    }
}