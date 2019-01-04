<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars;


/**
 *
 *
 */
interface Engine
{
    /**
     * Returns the script located at the given path
     * 
     * TODO: Check whether this method is required here as well, as it is actually defined
     *       in the class 'Library'
     * 
     * @param string $path
     * @return Script
     */
    public function script(string $path, Script $referer = null): Script;

    /**
     * Parses and compiles the script
     * 
     * @param Script $script
     * @return Template
     */
    public function template(Script $script): Template;

    /**
     * Returns the helper store
     * 
     * @return Helper\Store
     */
    public function helpers(): Helper\Store;

}
