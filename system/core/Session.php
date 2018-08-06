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
    /**
     * Starts the session if not started yet.
     */
    public static function init()
    {
        if (session_status() == PHP_SESSION_NONE) {     // if (session_id() == '')
            session_start();
        }
    }

    /**
     * Set session key and value
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get session value by $key
     *
     * @param  $key
     * @return mixed
     */
    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
    }
}