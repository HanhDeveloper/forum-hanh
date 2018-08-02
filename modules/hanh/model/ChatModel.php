<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use Core\Model;

class ChatModel extends Model
{
    protected $table = 'chats';

    public static function getMessages($index = 1)
    {
        return ChatModel::where('id', '>', $index)->get();
    }
}