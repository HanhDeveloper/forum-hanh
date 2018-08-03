<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Library;

/**
 * Class BotMan
 * @package Library
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