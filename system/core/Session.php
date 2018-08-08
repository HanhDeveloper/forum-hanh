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
        return (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true);
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
     * Sets session key and value
     *
     * @param $data
     * @param $value
     */
    public static function set($data, $value = null)
    {
        if (is_array($data)) {
            foreach ($data as $key => &$value) {
                $_SESSION[$key] = $value;
            }
            return;
        }

        $_SESSION[$data] = $value;
    }

    /**
     * Get value that has been set in the session.
     *
     * @param string $key
     * @return mixed|null
     */
    public static function get(string $key)
    {
        if (! empty($key) && $value = array_search($key, $_SESSION)) {
            return $value;
        } elseif (empty($_SESSION)) {
            return [];
        }

        if (! empty($key)) {
            return null;
        }
    }

    /**
     * Returns whether an index exists in the session array.
     *
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove one or more session properties.
     *
     * @param $key
     */
    public function remove($key)
    {
        if (is_array($key)) {
            foreach ($key as $k) {
                unset($_SESSION[$k]);
            }
            return;
        }

        unset($_SESSION[$key]);
    }

    /**
     * reset session id, delete session file on server, and re-assign the values.
     *
     * @param array $data
     */
    public static function reset(array $data)
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