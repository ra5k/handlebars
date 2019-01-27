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
use Ra5k\Handlebars\{Arguments, Context, Flow};


/**
 *
 *
 *
 */
final class With extends Standard
{

    /**
     * 
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     * @return mixed
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        if ($args->at(1)) {
            $context = $context->child($args->at(1));
            $overlay = new Context\Overlay($context, new Context\Simple($args->hash()));
            $result = $flow->exec($overlay);
        } else {
            $result = $flow->alt($context);
        }
        return $result;
    }

}
