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
final class Callback extends Standard
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     * @return mixed
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        $callback = $this->callback;
        return $callback($args, $context, $flow);
    }

}
