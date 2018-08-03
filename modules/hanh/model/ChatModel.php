<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use Core\DB;

class ChatModel extends DB
{
    public static function getMessages($index = 1)
    {
        return self::table('chats')
            ->where('id', '>', $index)
            ->get();
    }

    public static function saveToDb($msg)
    {
        self::table('chats')->insert(
            ['message' => $msg]
        );
    }
}