<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

use Exception;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var \Twig_Environment
     */
    private $twig = null;

    /**
     * @var Response
     */
    private $response = null;

    /**
     * View constructor.
     */
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(BASE_DIR . '/views');
        $this->twig = new Twig_Environment($loader);
    }

    /**
     * Renders a template.
     *
     * @param string $name
     * @param array $context
     */
    public function render($name, array $context = array())
    {
        $template = $this->twig->render($name, $context);
        //$this->response->setContent($template);
        echo $template;
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     * @throws Exception
     */
    public function __call($name, $args)
    {
        if (!method_exists($this->twig, $name))
            throw new Exception("does not have a method: $name");

        return call_user_func_array(array($this->twig, $name), $args);
    }
}