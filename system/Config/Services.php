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