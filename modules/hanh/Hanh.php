<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh;

use Core\Controller;
use Hanh\Models\DemoModel;

/**
 * Class Hanh
 * @package hanh
 */
class Hanh extends Controller
{
    public function index()
    {
        $user = DemoModel::find(1);
        $this->view->render('index', array('user' => $user));
    }

    public function home($id)
    {
        var_dump($id);
        $this->view->render('index', array('title' => 'Fabien'));
    }
}