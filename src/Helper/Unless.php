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
use Ra5k\Handlebars\{Arguments, Flow, Context};


/**
 *
 *
 *
 */
final class Unless extends Standard
{

    /**
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     * @return mixed
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        $satisfied = !$args->at(1);
        if ($satisfied) {
            $flow->exec($context);
        } else {
            $flow->alt($context);
        }
        return $satisfied;
    }

}
