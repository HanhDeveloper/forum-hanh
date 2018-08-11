<?php
/**
 * @author: Hanh <hanh.cho.do@gmail.com>
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
     * Removes all of the view data from the system.
     *
     * @return RendererInterface
     */
    public function resetData();
}