<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Hanh\Model;

use HDev\Model;

class BotModel extends Model
{
    public static function botReply($msg)
    {
        $bot = self::table('chatbox_simi')
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