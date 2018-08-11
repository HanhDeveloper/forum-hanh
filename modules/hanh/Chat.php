<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh;

use hanh\Model\BotModel;
use hanh\Model\ChatModel;
use HDev\Controller;
use HDev\Session\Session;

class Chat extends Controller
{
    public function anyIndex()
    {
        return view('chat');
    }

    public function postMessages()
    {
        $last_id = $this->request->post('last_id');
        return view('json', [
            'success' => true,
            'result'  => ChatModel::getMessages($last_id),
        ]);
    }

    public function postSave()
    {
        Session::set('user_id', 3);
        $message = $this->request->post('msg');
        ChatModel::saveToDb(['message' => $message, 'user_id' => Session::getUserId()]);
        $reply = BotModel::botReply($message);
        $result = ChatModel::saveToDb(['message' => $reply]);
        return view('json', [
            'success' => true,
            'result'  => $result,
        ]);
    }
}