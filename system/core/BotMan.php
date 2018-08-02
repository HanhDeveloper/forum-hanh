<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class BotMan
 * @package Core
 */
class BotMan
{
    /**
     * BotMan constructor.
     */
    public function __construct()
    {
    }

    public function getAnswer($answer)
    {
        if ($answer == 'answer')
            return 'message';
    }
}