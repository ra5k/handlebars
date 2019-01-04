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
use Ra5k\Handlebars\{Arguments, Context, Flow, Exception};


/**
 *
 *
 *
 */
final class Block extends Standard
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
        $name = $args->at(1);
        $params = $flow->params();
        //
        if (!$name) {
            throw new Exception\RuntimeException("Block name must not be empty");
        }
//        if (isset($params['blocks'])) {
//            /* @var $node Inheritance\Node */
//            $node = $params['blocks'];
//            $node->register($name, $flow);
//        } else
        if (isset($params['inheritance'])) {
            /* @var $chain Inheritance\Chain */
            $chain = $params['inheritance'];
            $chain->tail()->register($name, $flow);
            $block = $chain->head()->closest($name);
            if ($block->isValid()) {
                $result = $block->withParams(['block' => $name])->exec($context);
            } else {
                $result = $flow->exec($context);
            }
        } else {
            $result = $flow->exec($context);
        }
        return $result;
    }

}
