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
use Countable;

/**
 *
 *
 *
 */
final class Each extends Standard
{

    /**
     *
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        $empty = true;
        $result = null;
        $offset = 0;
        $items = $args->at(1);
        $count = $this->count($items);
        $sequence = new Sequence($items);
        //
        foreach ($sequence as $key => $value) {
            $empty = false;
            $first = ($offset === 0);
            $last  = ($count === null) ? null : ($offset == $count - 1);
            $sub = $context->child($value);
            $tmp = ['this' => $value, '@key' => $key, '@first' => $first, '@last' => $last] + $args->hash();
            $result = $flow->exec(new Context\Overlay($sub, new Context\Simple($tmp)));
            $offset++;
        }
        if ($empty) {
            $result = $flow->alt($context);
        }
        return $result;
    }

    /**
     * @param Countable $items
     * @return int|null
     */
    private function count($items)
    {
        if (is_array($items)) {
            $count = count($items);
        } else if ($items instanceof Countable) {
            $count = $items->count();
        } else {
            $count = null;
        }
        return $count;
    }

}
