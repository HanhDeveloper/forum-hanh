<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use Core\DB;

class ChatModel extends DB
{
    public static function getMessages($index = 0)
    {
        $index or $index = 0;
        return self::table('chats')
            ->join('users', 'chats.user_id', '=', 'users.id')
            ->where('chats.id', '>', $index)
            ->select('chats.id', 'chats.user_id', 'chats.message', 'chats.time', 'users.fullname')
            ->get();
    }

    public static function saveToDb(array $input)
    {
        $values = array(
            'user_id' => 2,
            'message' => '',
            'time'    => time(),
        );
        $values = array_merge($values, $input);
        self::table('chats')->insert($values);
        return $values;
    }
}