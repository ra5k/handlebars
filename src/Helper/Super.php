<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Helper;


// [imports]
use Ra5k\Handlebars\{Arguments, Context, Flow};


/**
 *
 *
 *
 */
final class Super extends Standard
{

    /**
     * 
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        $result = null;
        $params = $flow->params();
        //
        if (isset($params['block']) && isset($params['inheritance'])) {
            /* @var $inheritance Inheritance\Chain */
            $chain = $params['inheritance'];            
            $name = $params['block'];
            $node = $chain->head()->base();
            $parent = $node->closest($name);
            if ($parent->isValid()) {
                $result = $parent->exec($context);
            } else {
                $result = $flow->exec($context);
            }
        } else {
            $result = $flow->exec($context);
        }
        return $result;
    }

}
