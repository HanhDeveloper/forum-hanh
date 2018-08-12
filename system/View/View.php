<?php
/**
 * @package      HDev
 * @author       Hanh <hanh.cho.do@gmail.com>
 * @copyright    2018 by Hanh Developer
 * @link         https://fb.com/hnv.97
 */

namespace HDev\View;

class View implements RendererInterface
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * Data that is made available to the Views.
     *
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
    private $output;

    /**
     * Filename Extension
     */
    private $fileExt = '.html';

    /**
     * View constructor.
     */
    public function __construct()
    {
        $twig_loader_filesystem = new \Twig_Loader_Filesystem(BASE_DIR . '/views');
        $this->twig = new \Twig_Environment($twig_loader_filesystem);
        $this->twig->addFunction(new \Twig_SimpleFunction('asset', function ($uri = '') {
            return 'http://localhost/' . $uri;
        }));
        $this->twig->addFunction(new \Twig_SimpleFunction('site_url', function ($uri = '') {
            return 'http://localhost/' . $uri;
        }));
    }

    /**
     * Sets several pieces of view data at once.
     *
     * @param array $data
     * @return RendererInterface
     */
    public function setData(array $data = [])
    {
        $this->data = array_merge($this->data, $data);
        return $this;
    }

    /**
     * Render a template.
     *
     * @param string $name
     * @return RendererInterface
     */
    public function render(string $name)
    {
        if ($name === 'json') {
            $this->output = $this->jsonEncode($this->data);
            return $this;
        }

        $name = str_replace($this->fileExt, '', $name) . $this->fileExt;
        $this->output = call_user_func_array([$this->twig, 'render'], [$name, $this->data]);
        return $this;
    }

    /**
     * Serialize array to JSON and used for the response.
     *
     * @param array $data
     * @return string Rendered output
     *
     */
    private function jsonEncode(array $data)
    {
        return json_encode($data);
    }

    /**
     * Removes all of the view data from the system.
     *
     * @return RendererInterface
     */
    public function resetData()
    {
        $this->data = [];
        return $this;
    }

    public function __toString()
    {
        return $this->output;
    }
}