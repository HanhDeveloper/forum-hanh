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
class BotModel extends Model
{
    protected $table = 'simi';

    public static function botReally($msg)
    {
        return self::where('ask', $msg)
            ->select('ans')
            ->first();
    }

    public static function saveBot($msg)
    {
        $botModel = new ChatModel();
        $botModel->message = $msg;
        $botModel->save();
    }
}