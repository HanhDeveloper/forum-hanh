<?php
/**
 * @package      HDev
 * @author       Hanh <hanh.cho.do@gmail.com>
 * @copyright    2018 by Hanh Developer
 * @link         https://fb.com/hnv.97
 */

namespace HDev\HTTP;

class Message
{
    /**
     * Message body.
     *
     * @var string
     */
    protected $body;

    /**
     * Returns the Message's body.
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the body of the current message.
     *
     * @param $data
     *
     * @return Message|Response
     */
    public function setBody($data)
    {
        $this->body = $data;
        return $this;
    }

    /**
     * Appends data to the body of the current message.
     *
     * @param $data
     *
     * @return Message|Response
     */
    public function appendBody($data)
    {
        $this->body .= (string)$data;
        return $this;
    }
}