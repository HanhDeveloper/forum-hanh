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
     * Holds HTTP response statuses
     */
    private const STATUS_CODES = array(
        // 1xx: Informational
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing', // http://www.iana.org/go/rfc2518
        103 => 'Early Hints', // http://www.ietf.org/rfc/rfc8297.txt
        // 2xx: Success
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information', // 1.1
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status', // http://www.iana.org/go/rfc4918
        208 => 'Already Reported', // http://www.iana.org/go/rfc5842
        226 => 'IM Used', // 1.1; http://www.ietf.org/rfc/rfc3229.txt
        // 3xx: Redirection
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found', // Formerly 'Moved Temporarily'
        303 => 'See Other', // 1.1
        304 => 'Not Modified',
        305 => 'Use Proxy', // 1.1
        306 => 'Switch Proxy', // No longer used
        307 => 'Temporary Redirect', // 1.1
        308 => 'Permanent Redirect', // 1.1; Experimental; http://www.ietf.org/rfc/rfc7238.txt
        // 4xx: Client error
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
        418 => "I'm a teapot", // April's Fools joke; http://www.ietf.org/rfc/rfc2324.txt
        // 419 (Authentication Timeout) is a non-standard status code with unknown origin
        421 => 'Misdirected Request', // http://www.iana.org/go/rfc7540 Section 9.1.2
        422 => 'Unprocessable Entity', // http://www.iana.org/go/rfc4918
        423 => 'Locked', // http://www.iana.org/go/rfc4918
        424 => 'Failed Dependency', // http://www.iana.org/go/rfc4918
        425 => 'Too Early', // https://datatracker.ietf.org/doc/draft-ietf-httpbis-replay/
        426 => 'Upgrade Required',
        428 => 'Precondition Required', // 1.1; http://www.ietf.org/rfc/rfc6585.txt
        429 => 'Too Many Requests', // 1.1; http://www.ietf.org/rfc/rfc6585.txt
        431 => 'Request Header Fields Too Large', // 1.1; http://www.ietf.org/rfc/rfc6585.txt
        451 => 'Unavailable For Legal Reasons', // http://tools.ietf.org/html/rfc7725
        499 => 'Client Closed Request', // http://lxr.nginx.org/source/src/http/ngx_http_request.h#0133
        // 5xx: Server error
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates', // 1.1; http://www.ietf.org/rfc/rfc2295.txt
        507 => 'Insufficient Storage', // http://www.iana.org/go/rfc4918
        508 => 'Loop Detected', // http://www.iana.org/go/rfc5842
        510 => 'Not Extended', // http://www.ietf.org/rfc/rfc2774.txt
        511 => 'Network Authentication Required', // http://www.ietf.org/rfc/rfc6585.txt
        599 => 'Network Connect Timeout Error', // https://httpstatuses.com/599
    );

    /**
     * List of all HTTP request headers.
     *
     * @var array
     */
    private $headers = [];

    /**
     * The current reason phrase for this response.
     *
     * @var string
     */
    private $reason;

    /**
     * The current status code for this response.
     *
     * @var int
     */
    private $statusCode = 200;

    /**
     * The body.
     *
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $configs = array(
        'version' => '1.0',
        'charset' => 'UTF-8',
    );

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
     * Sends the output to the browser.
     */
    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
        return $this;
    }

    /**
     * Sends the headers of this HTTP request to the browser.
     *
     * @return Response
     */
    private function sendHeaders()
    {
        // Have the headers already been sent?
        if (headers_sent()) {
            return $this;
        }

        // If null, will use the default provided for the status code.
        $this->reason or $this->reason = self::STATUS_CODES[$this->statusCode];

        // HTTP Status
        header(sprintf('HTTP/%s %s %s', $this->configs['version'], $this->statusCode, $this->reason), true, $this->statusCode);

        // If Content-Type is already exists in headers, then don't send it
        if (! array_key_exists('Content-Type', $this->headers)) {
            header('Content-Type: ' . 'text/html; charset=' . $this->configs['charset']);
        }

        // Send all of our headers
        foreach ($this->headers as $name => $value) {
            header($name . ': ' . $value, true, $this->statusCode);
        }

        return $this;
    }

    /**
     * Sends the message to the browser.
     *
     * @return Response
     */
    private function sendBody()
    {
        echo $this->body;
        return $this;
    }

    /**
     * Sets the body of the current message.
     *
     * @param $data
     * @return Response
     */
    public function setBody($data)
    {
        $this->body = $data;
        return $this;
    }

    /**
     * Sets the Content Type header for current response.
     *
     * @param string $mime
     * @return Response
     */
    public function setContentType(string $mime)
    {
        $this->headers['Content-Type'] = $mime;
        return $this;
    }

    /**
     * Set the response status code.
     *
     * @param int    $code HTTP status code
     * @param string $reason
     * @return Response
     */
    public function setStatusCode(int $code, string $reason = '')
    {
        if ($code < 100 || $code > 599)
            throw new \RuntimeException('Status code invalid.');

        if (isset(self::STATUS_CODES[$code]))
            throw new \RuntimeException('Status code invalid.');

        $this->statusCode = $code;

        if (! empty($reason)) {
            $this->reason = $reason;
        } else {
            $this->reason = self::STATUS_CODES[$code];
        }

        return $this;
    }
}