<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace hanh\models;

use Core\Model;

/**
 * Class ChatModel
 * @package hanh\models
 */
class ChatModel extends Model
{
    protected $table = 'chats';

    public static function getMessages($index = 1)
    {
        return self::where('id', '>', 0)
            ->get();
    }
}