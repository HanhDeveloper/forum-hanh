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
     * @var string
     */
    private $content;

    /**
     * Sends HTTP headers and content.
     */
    public function send()
    {
        echo $this->content;
        return $this;
    }

    /**
     * Sets content for the current web response.
     *
     * @param string $content The response content
     * @return Response
     */
    public function setContent($content = "")
    {
        $this->content = $content;
        return $this;
    }
}