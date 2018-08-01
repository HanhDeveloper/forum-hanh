<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class Request
 * @package Core
 */
class Request
{
    /**
     * Enable XSS flag
     *
     * Determines whether the XSS filter is always active when
     * GET, POST or COOKIE data is encountered.
     * Set automatically based on config setting.
     *
     * @var bool
     */
    protected $_enable_xss = FALSE;

    /**
     * Fetch from array
     *
     * Internal method used to retrieve values from global arrays.
     *
     * @param array &$array    $_GET, $_POST, $_COOKIE, $_SERVER, etc.
     * @param mixed $index     Index for item to be fetched from $array
     * @param bool  $xss_clean Whether to apply XSS filtering
     * @return mixed
     */
    protected function _fetch_from_array(&$array, $index = NULL, $xss_clean = NULL)
    {
        is_bool($xss_clean) OR $xss_clean = $this->_enable_xss;

        // If $index is NULL, it means that the whole $array is requested
        isset($index) OR $index = array_keys($array);

        // allow fetching multiple keys at once
        if (is_array($index)) {
            $output = array();
            foreach ($index as $key) {
                $output[$key] = $this->_fetch_from_array($array, $key, $xss_clean);
            }

            return $output;
        }

        if (isset($array[$index])) {
            $value = $array[$index];
        } elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) // Does the index contain array notation
        {
            $value = $array;
            for ($i = 0; $i < $count; $i++) {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') // Empty notation will return the value as array
                {
                    break;
                }

                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return NULL;
                }
            }
        } else {
            return NULL;
        }

        return ($xss_clean === TRUE)
            ? $this->security->xss_clean($value)
            : $value;
    }

    // --------------------------------------------------------------------

    /**
     * Fetch an item from the GET array
     *
     * @param mixed $index     Index for item to be fetched from $_GET
     * @param bool  $xss_clean Whether to apply XSS filtering
     * @return mixed
     */
    public function get($index = NULL, $xss_clean = NULL)
    {
        return $this->_fetch_from_array($_GET, $index, $xss_clean);
    }

    // --------------------------------------------------------------------

    /**
     * Fetch an item from the POST array
     *
     * @param mixed $index     Index for item to be fetched from $_POST
     * @param bool  $xss_clean Whether to apply XSS filtering
     * @return mixed
     */
    public function post($index = NULL, $xss_clean = NULL)
    {
        return $this->_fetch_from_array($_POST, $index, $xss_clean);
    }

    // --------------------------------------------------------------------

    /**
     * Fetch an item from POST data with fallback to GET
     *
     * @param string $index     Index for item to be fetched from $_POST or $_GET
     * @param bool   $xss_clean Whether to apply XSS filtering
     * @return mixed
     */
    public function post_get($index, $xss_clean = NULL)
    {
        return isset($_POST[$index])
            ? $this->post($index, $xss_clean)
            : $this->get($index, $xss_clean);
    }

    // --------------------------------------------------------------------

    /**
     * Fetch an item from GET data with fallback to POST
     *
     * @param string $index     Index for item to be fetched from $_GET or $_POST
     * @param bool   $xss_clean Whether to apply XSS filtering
     * @return mixed
     */
    public function get_post($index, $xss_clean = NULL)
    {
        return isset($_GET[$index])
            ? $this->get($index, $xss_clean)
            : $this->post($index, $xss_clean);
    }

    /**
     * detect if request is Ajax
     *
     * @return boolean
     */
    public function isAjax()
    {
        if (! empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
        }
        return FALSE;
    }

    /**
     * detect if request is POST request
     *
     * @return boolean
     */
    public function isPost()
    {
        return $_SERVER["REQUEST_METHOD"] === "POST";
    }

    /**
     * detect if request is GET request
     *
     * @return boolean
     */
    public function isGet()
    {
        return $_SERVER["REQUEST_METHOD"] === "GET";
    }
}