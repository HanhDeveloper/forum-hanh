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

namespace HDev\View;

interface ContentType
{
    const APPLICATION_XML             = "application/xml";
    const APPLICATION_ATOM_XML        = "application/atom+xml";
    const APPLICATION_XHTML_XML       = "application/xhtml+xml";
    const APPLICATION_SVG_XML         = "application/svg+xml";
    const APPLICATION_JSON            = "application/json";
    const APPLICATION_FORM_URLENCODED = "application/x-www-form-urlencoded";
    const MULTIPART_FORM_DATA         = "multipart/form-data";
    const APPLICATION_OCTET_STREAM    = "application/octet-stream";
    const TEXT_PLAIN                  = "text/plain";
    const TEXT_XML                    = "text/xml";
    const TEXT_HTML                   = "text/html";
}