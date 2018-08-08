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
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Extended for templates file
     */
    const EXT = '.html';

    /**
     * View constructor.
     *
     * @param Loader $loader
     */
    public function __construct(Loader $loader)
    {
        // initialization of the required object
        $this->request = $loader->request();
        $this->response = $loader->response();
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
     */
    public function render($name, array $context = array())
    {
        $name = str_replace(self::EXT, '', $name) . self::EXT;
        $template = call_user_func_array(array($this->twig, 'render'), array($name, $context));
        $this->response->setContent($template);
    }

    /**
     * Render a JSON view.
     *
     * @param  array $data
     * @return string  Rendered output
     *
     */
    public function renderJson($data)
    {
        $jsonData = $this->jsonEncode($data);
        $this->response->type('application/json')->setContent($jsonData);
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
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        if (! method_exists($this->twig, $name))
            throw new \Exception("Does not have a method: $name");

        return call_user_func_array(array($this->twig, $name), $args);
    }
}