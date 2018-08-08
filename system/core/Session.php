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
     * Get IsLoggedIn value(boolean)
     *
     * @return boolean
     */
    public static function getIsLoggedIn()
    {
        return isset($_SESSION['is_logged_in']) && is_bool($_SESSION['is_logged_in']) ? $_SESSION['is_logged_in'] : false;
    }

    /**
     * Get User ID.
     *
     * @return int|null
     */
    public static function getUserId()
    {
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }

    /**
     * Get User Role
     *
     * @return int|null
     */
    public static function getUserRole()
    {
        return isset($_SESSION['role']) ? (int)$_SESSION['role'] : null;
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
     * @return mixed|null
     */
    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * reset session id, delete session file on server, and re-assign the values.
     *
     * @param  array $data
     * @return string
     */
    public static function reset($data)
    {
        // remove old and regenerate session ID.
        session_regenerate_id(true);
        $_SESSION = array();

        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = (int)$data['user_id'];
        $_SESSION['role'] = $data['role'];

        // save these values in the session,
        // they are needed to avoid session hijacking and fixation
        $_SESSION['ip'] = $data['ip'];
        $_SESSION['user_agent'] = $data['user_agent'];
        $_SESSION['generated_time'] = time();
    }

    /**
     * Remove the session
     * Delete session completely from the browser cookies and destroy it's file on the server
     */
    public static function destroy()
    {
        // clear session data
        $_SESSION = array();

        // remove session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // destroy session file on server(if not already)
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}