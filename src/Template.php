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
interface Template
{

    /**
     * Writes the template to PHP's output stream (php://output) within a given context
     * 
     * @param mixed $context
     * @return mixed
     */
    public function write($context);
    
}
