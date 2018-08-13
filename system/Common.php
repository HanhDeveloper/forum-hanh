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

// Configuration for: Database Connection
defined("DB_DRIVER") or define('DB_DRIVER', 'mysql');
defined("DB_HOST") or define('DB_HOST', 'localhost');
defined("DB_NAME") or define('DB_NAME', 'demo');
defined("DB_USER") or define('DB_USER', 'root');
defined("DB_PASS") or define('DB_PASS', '');

// Options for developer
define('LOG_MODE', false);


if (! function_exists('view')) {
    /**
     * Grabs the current RendererInterface-compatible class
     * and tells it to render the specified view. Simply provides
     * a convenience method that can be used in Controllers,
     * libraries, and routed closures.
     *
     * NOTE: Does not provide any escaping of the data, so that must
     * all be handled manually by the developer.
     *
     * @param string $name
     * @param array  $data
     * @param array  $options Unused - reserved for third-party extensions.
     *
     * @return string
     */
    function view(string $name, array $data = [], array $options = [])
    {
        /**
         * @var \HDev\View\View $renderer
         */
        $renderer = \HDev\Config\Services::renderer();
        return $renderer->setData($data)
            ->render($name, $options);
    }
}
