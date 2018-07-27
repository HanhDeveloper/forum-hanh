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
    public function getIndex()
    {
        $user = DemoModel::all();
        $this->view->render('index', array('user' => $user));
    }

    public function getHanh($id)
    {
        $this->view->render('index', array('title' => 'Fabien'));
    }
}