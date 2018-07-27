<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace hanh;

use Core\Controller;
use hanh\models\ChatModel;

/**
 * Class Chat
 * @package hanh
 */
class Chat extends Controller
{
    public function getIndex()
    {
        $this->view->render('chat');
    }

    public function postMessages()
    {
        $first_id = $this->request->post('first_id');
        $last_id = '';
        $this->view->renderJson([
            'success' => true,
            '$first_id' => $first_id,
            '$last_id' => $last_id,
            'result' => ChatModel::all(),
        ]);
    }
}