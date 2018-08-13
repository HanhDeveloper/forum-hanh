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

namespace HDev\Log;

class Logger
{
    /**
     * @access public
     * @static static method
     * @param  string $header
     * @param  string $message
     * @param  string $filename
     * @param  string $linenum
     */
    public static function log($header = "", $message = "", $filename = "", $linenum = "")
    {
        $logfile = BASE_DIR . "/logs/log.txt";
        $date = date("d/m/Y G:i:s");
        $err = $date . " | " . $filename . " | " . $linenum . " | " . $header . "\n";

        $message = is_array($message) ? implode("\n", $message) : $message;
        $err .= $message . "\n*******************************************************************\n\n";

        // log/write error to log file
        error_log($err, 3, $logfile);
    }
}