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
interface Helper
{
    /**
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     */
    public function exec(Arguments $args, Context $context, Flow $flow);

    /**
     * @return bool
     */
    public function exists(): bool;
    
}
