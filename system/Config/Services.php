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

class Services extends BaseService
{
    /**
     * The Renderer class is the class
     * that actually displays a file to the user.
     *
     * @param bool $getShared
     *
     * @return \HDev\View\View
     */
    public static function renderer($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('renderer');
        }
        return new \HDev\View\View();
    }

    /**
     * The Request class models an HTTP request.
     *
     * @param bool $getShared
     *
     * @return \HDev\HTTP\Request
     */
    public static function request($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('request');
        }
        return new \HDev\HTTP\Request();
    }

    /**
     * The Response class models an HTTP response.
     *
     * @param bool $getShared
     *
     * @return \HDev\HTTP\Response
     */
    public static function response($getShared = true)
    {
        if ($getShared) {
            return self::getSharedInstance('response');
        }
        return new \HDev\HTTP\Response();
    }
}