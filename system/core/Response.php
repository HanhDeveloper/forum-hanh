<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace Core;

/**
 * Class Response
 * @package Core
 */
class Response
{
    /**
     * @var array
     */
    private $configs = array(
        'headers'    => [],
        'content'    => '',
        'statusCode' => 200,
        'version'    => '1.0',
        'charset'    => 'UTF-8',
    );

    /**
     * @var string
     */
    private $content = '';

    /**
     * Response constructor.
     *
     * @param array $configs
     */
    public function __construct(array $configs = array())
    {
        $this->configs = array_merge($this->configs, $configs);
    }

    /**
     * Sends HTTP headers and content.
     */
    public function send()
    {
        // sends http headers to the client
        $this->sendHeaders();

        // this sends the content
        $this->sendContent();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif ('cli' !== PHP_SAPI) {
            $this->flushBuffer();
        }

        return $this;
    }

    /**
     * Flushes output buffers.
     */
    private function flushBuffer()
    {
        flush(); // ob_flush();
    }

    /**
     * Sends HTTP headers.
     *
     * @return Response
     */
    private function sendHeaders()
    {
        // check headers have already been sent by the developer
        if (headers_sent()) {
            return $this;
        }

        // holds HTTP response statuses
        $statusTexts = array(
            100 => 'Continue',
            101 => 'Switching Protocols',

            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',

            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            307 => 'Temporary Redirect',

            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            426 => 'Upgrade Required',
            428 => 'Precondition Required',
            429 => 'Too Many Requests',
            431 => 'Request Header Fields Too Large',

            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            511 => 'Network Authentication Required',
        );
        $code = $this->configs['statusCode'];
        $text = isset($statusTexts[$code]) ? $statusTexts[$code] : '';

        // status
        header(sprintf('HTTP/%s %s %s', $this->configs['version'], $code, $text), true, $code);

        // Content-Type
        // if Content-Type is already exists in headers, then don't send it
        if (! array_key_exists('Content-Type', $this->configs['headers'])) {
            header('Content-Type: ' . 'text/html; charset=' . $this->configs['charset']);
        }

        // headers
        foreach ($this->configs['headers'] as $name => $value) {
            header($name . ': ' . $value, true, $code);
        }

        return $this;
    }

    /**
     * Send content for the current web response.
     *
     * @return Response
     */
    private function sendContent()
    {
        echo $this->content;
        return $this;
    }

    /**
     * Set content for the current web response.
     *
     * @param string $content
     * @return Response
     */
    public function setContent($content = "")
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set the response content-type.
     *
     * @param string|null $contentType
     * @return Response
     */
    public function type($contentType = null)
    {
        if ($contentType === null) unset($this->configs['headers']['Content-Type']);
        else  $this->configs['headers']['Content-Type'] = $contentType;
        return $this;
    }

    /**
     * Set the response status code.
     *
     * @param int $code HTTP status code
     * @return Response
     */
    public function setStatusCode(int $code)
    {
        $this->configs['statusCode'] = $code;
        return $this;
    }
}