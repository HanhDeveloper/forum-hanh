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
     * @var View
     */
    private $view = null;

    /**
     * @var Request
     */
    private $request = null;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Magic accessor for model autoloading.
     *
     * @param  string $name Property name
     * @return object The model instance
     */
    public function __get($name)
    {
        return $this->loadModel($name);
    }

    /**
     * load model
     * It assumes the model's constructor doesn't need parameters for constructor
     *
     * @param string $model class name
     * @return Model
     */
    public function loadModel($model)
    {
        $uc_model = ucwords($model);
        return $this->{$model} = new $uc_model();
    }

    public function index()
    {
        $this->view->render('index.html', array('title' => 'Fabien'));
    }
}