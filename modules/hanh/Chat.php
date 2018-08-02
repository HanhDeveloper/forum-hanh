<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace hanh;

use Core\Controller;
use hanh\Model\BotModel;
use hanh\Model\ChatModel;

/**
 * Class Chat
 * @package hanh
 */
class Chat extends Controller
{
    public function anyIndex()
    {

        $bot = new BotModel();
        var_dump($bot->demo);
        $bot->demo = 'hanh5555';
        $bot2 = new BotModel();
        var_dump($bot2->demo);

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
        $msg = $this->request->post('msg');
        $json_str = file_get_contents('php://input');

        $bot = BotModel::botReally($msg);
        if (isset($bot->ans))
            $message = $bot->ans;
        else
            $message = 'Bot chưa được học từ này';
        BotModel::saveBot($message);
        $this->view->renderJson([
            'success' => TRUE,
            'result'  => $msg,
            'result2' => $json_str,
        ]);
    }
}