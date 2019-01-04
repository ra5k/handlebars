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
final class Derived extends Standard
{

    /**
     *
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        $name = (string) $args->at(1);
        $partial = $flow->load($name, $context);
        //
        if ($partial->isValid()) {
            //
            $inheritance = $this->inheritance($flow);
            // $target = $inheritance->head();
            ob_start();
            $flow->withParams(['inheritance' => $inheritance /*, 'blocks' => $target */])->exec($context);
            ob_end_clean();
            //
            $inheritance->extend(new Inheritance\Node);
            $context = new Context\Overlay($context, new Context\Simple($args->hash()));
            $result = $partial->withParams(['inheritance' => $inheritance /*, 'blocks' => null */])->exec($context);
        } else {
            $result = $flow->exec($context);
        }
        return $result;
    }

    /**
     * @param Flow $flow
     * @return Battery
     */
    private function inheritance(Flow $flow): Inheritance\Chain
    {
        $params = $flow->params();
        return $params['inheritance'] ?? new Inheritance\Chain();
    }

}