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

interface RendererInterface
{
    /**
     * Sets several pieces of view data at once.
     *
     * @param array $data
     * @return RendererInterface
     */
    public function setData(array $data = []);

    /**
     * Render a template.
     *
     * @param string $name
     * @return RendererInterface
     */
    public function render(string $name);

    /**
     * Removes all of the view data from the system.
     *
     * @return RendererInterface
     */
    public function resetData();
}