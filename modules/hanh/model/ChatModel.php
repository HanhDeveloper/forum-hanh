<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use HDev\Model;

class ChatModel extends Model
{
    public static function getMessages($index = 0)
    {
        return self::table('chatbox')
            ->join('users', 'chatbox.user_id', '=', 'users.id')
            ->where('chatbox.id', '>', $index ?? $index = 0)
            ->select('chatbox.id', 'chatbox.user_id', 'chatbox.message', 'chatbox.time', 'users.fullname')
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
        self::table('chatbox')->insert($values);
        return $values;
    }
}