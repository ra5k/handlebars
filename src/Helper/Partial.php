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
final class Partial extends Standard
{

    /**
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        $name = (string) $args->at(1);        
        $partial = $flow->load($name, $context);
        if ($partial->isValid()) {  
            $overlay = new Context\Overlay($context, new Context\Simple($args->hash()));
            $result = $partial->exec($overlay);
        } else {
            $result = $flow->exec($context);
        }        
        return $result;
    }

}
