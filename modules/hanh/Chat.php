<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace hanh;

use Core\Controller;
use hanh\models\BotModel;
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
        $last_id = $this->request->post('last_id');
        $this->view->renderJson([
            'success' => TRUE,
            '$first_id' => $first_id,
            '$last_id' => $last_id,
            'result' => ChatModel::getMessages($last_id),
        ]);
    }

    public function postSave()
    {
        $msg = $this->request->post('message');
        $bot = BotModel::botReally($msg);
        if (isset($bot->ans))
            $message = $bot->ans;
        else
            $message = 'Bot chưa được học từ này';
        BotModel::saveBot($message);
        $this->view->renderJson([
            'success' => TRUE,
            'result' => $message,
        ]);
    }
}