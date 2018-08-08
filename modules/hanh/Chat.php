<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh;

use Core\Controller;
use Core\Session;
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
        $last_id = $this->request->post('last_id');
        $this->view->renderJson([
            'success'   => true,
            '$first_id' => $first_id,
            '$last_id'  => $last_id,
            'result'    => ChatModel::getMessages($last_id),
        ]);
    }

    public function postSave()
    {
        //Session::set('user_id', 3);
        $message = $this->request->post('msg');
        ChatModel::saveToDb(['message' => $message, 'user_id' => Session::getUserId()]);
        $reply = BotModel::botReply($message);
        $result = ChatModel::saveToDb(['message' => $reply]);
        $this->view->renderJson([
            'success' => true,
            'result'  => $result,
        ]);
    }
}