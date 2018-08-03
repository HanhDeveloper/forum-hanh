<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class Session
 * @package Core
 */
class Session
{
    public function __construct()
    {
    }

    /**
     * Starts the session if not started yet.
     */
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {     // if (session_id() == '')
            session_start();
        }
    }
}