<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use Core\Model;

class BotModel extends Model
{
    protected $table = 'simi';

    public $demo = 'hanh';

    public static function botReally($msg)
    {
        return BotModel::where('ask', $msg)->select('ans')->first();
    }

    public static function saveBot($msg)
    {
        $botModel = new ChatModel();
        $botModel->message = $msg;
        $botModel->save();
    }
}