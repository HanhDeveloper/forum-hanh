<?php
/**
 * @package      HDev
 * @author       Hanh <hanh.cho.do@gmail.com>
 * @copyright    2018 by Hanh Developer
 * @link         https://fb.com/hnv.97
 */

namespace HDev\HTTP;

interface RequestInterface
{
    /**
     * Get the request method.
     *
     * @param bool $upper Whether to return in upper or lower case.
     *
     * @return string
     */
    public function getMethod($upper = false): string;

    /**
     * Fetch an item from the $_SERVER array.
     *
     * @param string $index  Index for item to be fetched from $_SERVER
     * @param null   $filter A filter name to be applied
     *
     * @return mixed
     */
    public function getServer($index = null, $filter = null);
}