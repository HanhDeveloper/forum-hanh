<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var Controller
     */
    private $controller;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Extended for templates file
     */
    private const EXT = '.html';

    /**
     * View constructor.
     *
     * @param Controller $controller
     */
    public function __construct(Controller $controller)
    {
        // initialization of the required object
        $this->controller = $controller;
        $twig_loader_filesystem = new \Twig_Loader_Filesystem(BASE_DIR . '/views');
        $this->twig = new \Twig_Environment($twig_loader_filesystem);
        $this->registerFunc();
    }

    private function registerFunc()
    {
        $this->twig->addFunction(new \Twig_SimpleFunction('asset', function ($uri = '') {
            return 'http://localhost/' . $uri;
        }));
        $this->twig->addFunction(new \Twig_SimpleFunction('site_url', function ($uri = '') {
            return 'http://localhost/' . $uri;
        }));
    }

    /**
     * Render a template.
     *
     * @param string $name
     * @param array  $context
     * @return string  Rendered output
     */
    public function render(string $name, array $context = array())
    {
        $name = str_replace(self::EXT, '', $name) . self::EXT;
        $template = call_user_func_array(array($this->twig, 'render'), array($name, $context));
        $this->controller->response->setBody($template);
        return $template;
    }

    /**
     * Render a JSON view.
     *
     * @param  array $data
     * @return string  Rendered output
     *
     */
    public function renderJson(array $data)
    {
        $jsonData = $this->jsonEncode($data);
        $this->controller->response->setContentType('application/json')->setBody($jsonData);
        return $jsonData;
    }

    /**
     * Serialize array to JSON and used for the response.
     *
     * @param  array $data
     * @return string  Rendered output
     *
     */
    public function jsonEncode(array $data)
    {
        return json_encode($data);
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
            throw new \RuntimeException("Does not have a method: $name");

        return call_user_func_array(array($this->twig, $name), $args);
    }
}