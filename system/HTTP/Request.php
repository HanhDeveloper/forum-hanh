<?php
/**
 * Hanh Developer
 *
 * @package     HDev
 * @author      Hanh <hanh.cho.do@gmail.com>
 * @copyright   2018 by Hanh Developer
 * @link        https://fb.com/hnv.97
 * @filesource
 */

namespace HDev\HTTP;

class Request extends Message implements RequestInterface
{
    /**
     * Request method.
     *
     * @var string
     */
    private $method;

    /**
     * Stores values we've retrieved from
     * PHP globals.
     * @var array
     */
    private $globals = [];

    /**
     * Request constructor.
     */
    public function __construct()
    {
        // Get our body from php://input
        $this->body = file_get_contents('php://input');
        $this->method = $this->getServer('REQUEST_METHOD') ?? 'GET';
    }

    /**
     * Get the request method.
     *
     * @param bool $upper Whether to return in upper or lower case.
     *
     * @return string
     */
    public function getMethod($upper = false): string
    {
        return ($upper) ? strtoupper($this->method) : strtolower($this->method);
    }

    /**
     * Fetch an item from the $_REQUEST object. This is the simplest way
     * to grab data from the request object and can be used in lieu of the
     * other get* methods in most cases.
     *
     * @param null $index
     * @param null $filter
     * @param null $flags
     *
     * @return mixed
     */
    public function getVar($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('request', $index, $filter, $flags);
    }

    /**
     * A convenience method that grabs the raw input stream and decodes
     * the JSON into an array.
     *
     * If $assoc == true, then all objects in the response will be converted
     * to associative arrays.
     *
     * @param bool $assoc   Whether to return objects as associative arrays
     * @param int  $depth   How many levels deep to decode
     * @param int  $options Bitmask of options
     *
     * @see http://php.net/manual/en/function.json-decode.php
     *
     * @return mixed
     */
    public function getJSON(bool $assoc = false, int $depth = 512, int $options = 0)
    {
        return json_decode($this->body, $assoc, $depth, $options);
    }

    /**
     * A convenience method that grabs the raw input stream(send method in PUT, PATCH, DELETE) and decodes
     * the String into an array.
     *
     * @return mixed
     */
    public function getRawInput()
    {
        parse_str($this->body, $output);
        return $output;
    }

    /**
     * Fetch an item from GET data.
     *
     * @param null $index  Index for item to fetch from $_GET.
     * @param null $filter A filter name to apply.
     * @param null $flags
     *
     * @return mixed
     */
    public function getGet($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('get', $index, $filter, $flags);
    }

    /**
     * Fetch an item from POST.
     *
     * @param null $index  Index for item to fetch from $_POST.
     * @param null $filter A filter name to apply
     * @param null $flags
     *
     * @return mixed
     */
    public function getPost($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('post', $index, $filter, $flags);
    }

    /**
     * Fetch an item from POST data with fallback to GET.
     *
     * @param null $index  Index for item to fetch from $_POST or $_GET
     * @param null $filter A filter name to apply
     * @param null $flags
     *
     * @return mixed
     */
    public function getPostGet($index = null, $filter = null, $flags = null)
    {
        // Use $_POST directly here, since filter_has_var only
        // checks the initial POST data, not anything that might
        // have been added since.
        return isset($_POST[$index]) ? $this->getPost($index, $filter, $flags) : $this->getGet($index, $filter, $flags);
    }

    /**
     * Fetch an item from GET data with fallback to POST.
     *
     * @param null $index  Index for item to be fetched from $_GET or $_POST
     * @param null $filter A filter name to apply
     * @param null $flags
     *
     * @return mixed
     */
    public function getGetPost($index = null, $filter = null, $flags = null)
    {
        // Use $_GET directly here, since filter_has_var only
        // checks the initial GET data, not anything that might
        // have been added since.
        return isset($_GET[$index]) ? $this->getGet($index, $filter, $flags) : $this->getPost($index, $filter, $flags);
    }
    //--------------------------------------------------------------------

    /**
     * Fetch an item from the COOKIE array.
     *
     * @param null $index  Index for item to be fetched from $_COOKIE
     * @param null $filter A filter name to be applied
     * @param null $flags
     *
     * @return mixed
     */
    public function getCookie($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('cookie', $index, $filter, $flags);
    }

    /**
     * Fetch an item from the $_SERVER array.
     *
     * @param int|null $index  Index for item to be fetched from $_SERVER
     * @param int|null $filter A filter name to be applied
     * @param null     $flags
     *
     * @return mixed
     */
    public function getServer($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('server', $index, $filter, $flags);
    }

    /**
     * Fetch an item from the $_ENV array.
     *
     * @param null $index  Index for item to be fetched from $_ENV
     * @param null $filter A filter name to be applied
     * @param null $flags
     *
     * @return mixed
     */
    public function getEnv($index = null, $filter = null, $flags = null)
    {
        return $this->fetchGlobal('env', $index, $filter, $flags);
    }

    /**
     * Allows manually setting the value of PHP global, like $_GET, $_POST, etc.
     *
     * @param string $method
     * @param        $value
     *
     * @return $this
     */
    public function setGlobal(string $method, $value)
    {
        $this->globals[$method] = $value;
        return $this;
    }

    /**
     * Fetches one or more items from a global, like cookies, get, post, etc.
     * Can optionally filter the input when you retrieve it by passing in
     * a filter.
     *
     * If $type is an array, it must conform to the input allowed by the
     * filter_input_array method.
     *
     * http://php.net/manual/en/filter.filters.sanitize.php
     *
     * @param int          $method Input filter constant
     * @param string|array $index
     * @param int          $filter Filter constant
     * @param null         $flags
     *
     * @return mixed
     */
    private function fetchGlobal($method, $index = null, $filter = null, $flags = null)
    {
        $method = strtolower($method);
        if (! isset($this->globals[$method])) {
            $this->populateGlobals($method);
        }
        // Null filters cause null values to return.
        if (is_null($filter)) {
            $filter = FILTER_DEFAULT;
        }
        // Return all values when $index is null
        if (is_null($index)) {
            $values = [];
            foreach ($this->globals[$method] as $key => $value) {
                $values[$key] = is_array($value)
                    ? $this->fetchGlobal($method, $key, $filter, $flags)
                    : filter_var($value, $filter, $flags);
            }
            return $values;
        }
        // allow fetching multiple keys at once
        if (is_array($index)) {
            $output = [];
            foreach ($index as $key) {
                $output[$key] = $this->fetchGlobal($method, $key, $filter, $flags);
            }
            return $output;
        }
        // Does the index contain array notation?
        if (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) {
            $value = $this->globals[$method];
            for ($i = 0; $i < $count; $i++) {
                $key = trim($matches[0][$i], '[]');
                if ($key === '') // Empty notation will return the value as array
                {
                    break;
                }
                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return null;
                }
            }
        }
        if (empty($value)) {
            $value = $this->globals[$method][$index] ?? null;
        }
        // Cannot filter these types of data automatically...
        if (is_array($value) || is_object($value) || is_null($value)) {
            return $value;
        }
        return filter_var($value, $filter, $flags);
    }

    /**
     * Saves a copy of the current state of one of several PHP globals
     * so we can retrieve them later.
     *
     * @param string $method
     */
    private function populateGlobals(string $method)
    {
        switch ($method) {
            case 'get':
                $this->globals['get'] = $_GET;
                break;
            case 'post':
                $this->globals['post'] = $_POST;
                break;
            case 'request':
                $this->globals['request'] = $_REQUEST;
                break;
            case 'cookie':
                $this->globals['cookie'] = $_COOKIE;
                break;
            case 'server':
                $this->globals['server'] = $_SERVER;
                break;
            default:
                $this->globals[$method] = [];
        }
    }
}