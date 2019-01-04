<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Helper;


// [import]
use Ra5k\Handlebars\{Helper, Arguments, Context, Flow};


/**
 * This helper does nothing
 *
 *
 */
final class Dummy implements Helper
{

    public function exists(): bool
    {
        return false;
    }

    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        // pass;
    }

}
