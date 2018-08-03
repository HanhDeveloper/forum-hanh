<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh;

use Core\Controller;
use hanh\Model\BotModel;
use hanh\Model\ChatModel;

class Chat extends Controller
{
    public function anyIndex()
    {
        $this->view->render('chat');
    }

    public function postMessages()
    {
        $first_id = $this->request->post('first_id');
        $last_id = $this->request->post('last_id') ? $this->request->post('last_id') : 0;
        $this->view->renderJson([
            'success'   => TRUE,
            '$first_id' => $first_id,
            '$last_id'  => $last_id,
            'result'    => ChatModel::getMessages($last_id),
        ]);
    }

    public function postSave()
    {
        $message = $this->request->post('msg');
        ChatModel::saveToDb($message);
        $reply = BotModel::botReply($message);
        ChatModel::saveToDb($reply);
        $this->view->renderJson([
            'success' => TRUE,
            'result'  => $message,
        ]);
    }
}