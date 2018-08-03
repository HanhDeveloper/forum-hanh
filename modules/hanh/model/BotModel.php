<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use Core\DB;

class BotModel extends DB
{
    public static function botReply($msg)
    {
        $bot = self::table('simi')
            ->where('ask', $msg)
            ->select('ans')
            ->first();
        if (isset($bot->ans))
            $reply = $bot->ans;
        else
            $reply = 'Bot chưa được học từ này';
        return $reply;
    }
}