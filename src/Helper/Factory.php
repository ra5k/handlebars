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
use Ra5k\Handlebars\{Arguments, Context, Flow, Helper};
use Ra5k\Handlebars\Exception\RuntimeException;

/**
 *
 *
 *
 */
final class Factory extends Standard
{
    /**
     * @var callable
     */
    private $factory;

    /**
     * @var Helper
     */
    private $actual;
    
    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->factory = $callback;
    }

    /**
     * @param Arguments $args
     * @param Context $context
     * @param Flow $flow
     * @return mixed
     * @throws RuntimeException
     */
    public function exec(Arguments $args, Context $context, Flow $flow)
    {
        if ($this->actual === null) {
            $factory = $this->factory;
            $helper = $factory($flow);
            if (!($helper instanceof Helper)) {
                $type = is_object($helper) ? get_class($helper) : gettype($helper);
                throw new RuntimeException("Factory did not return a valid Helper instance, $type given");
            }
            $this->actual = $helper;
        }
        return $this->actual->exec($args, $context, $flow);
    }

}
