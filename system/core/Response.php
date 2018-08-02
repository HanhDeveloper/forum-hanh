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
        'charset'    => 'UTF-8'
    );

    /**
     * @var string
     */
    private $content = '';

    /**
     * Holds HTTP response statuses.
     *
     * @var array
     */
    private $statusTexts = [
        200 => 'OK',
        302 => 'Found',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error'
    ];

    /**
     * Response constructor.
     *
     * @param array $configs
     */
    public function __construct(array $configs = array())
    {
        array_merge($this->configs, $configs);
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

        // status
        header(sprintf('HTTP/%s %s %s', $this->configs['version'], $this->configs['statusCode'], $this->getStatusText()), TRUE, $this->configs['statusCode']);

        // Content-Type
        // if Content-Type is already exists in headers, then don't send it
        if (! array_key_exists('Content-Type', $this->configs['headers'])) {
            header('Content-Type: ' . 'text/html; charset=' . $this->configs['charset']);
        }

        // headers
        foreach ($this->configs['headers'] as $name => $value) {
            header($name . ': ' . $value, TRUE, $this->configs['statusCode']);
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
     * @param string $content The response content
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
     * @param string|null $contentType The response content
     * @return Response
     */
    public function type($contentType = NULL)
    {
        if ($contentType === NULL) unset($this->configs['headers']['Content-Type']);
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

    /**
     * Get status code relevant text.
     *
     * @return string
     */
    public function getStatusText()
    {
        $code = $this->configs['statusCode'];
        return isset($this->statusTexts[$code]) ? $this->statusTexts[$code] : '';
    }
}