<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
 */

namespace HDev\Config;

class Services
{
    /**
     * The Renderer class is the class
     * that actually displays a file to the user.
     *
     * @return \HDev\View\View
     */
    public static function renderer()
    {
        return new \HDev\View\View();
    }
}