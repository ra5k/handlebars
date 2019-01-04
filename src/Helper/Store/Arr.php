<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Helper\Store;

// [imports]
use Ra5k\Handlebars\Helper\Store;
use Ra5k\Handlebars\Helper;
use Ra5k\Handlebars\Exception\InvalidArgumentException;
use ArrayIterator, Traversable;

/**
 *
 *
 *
 */
final class Arr implements Store
{

    /**
     * @var Helper[]
     */
    private $helpers;

    /**
     * @param array $helpers
     * @throws InvalidArgumentException
     */
    public function __construct(array $helpers)
    {
        $this->helpers = $helpers;
        foreach ($helpers as $i => $h) {
            if ($h instanceof Helper) {
                // pass;
            } else {
                throw new InvalidArgumentException("Item at ($i) is not a Helper instance");
            }
        }
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->helpers);
    }

    /**
     *
     * @param string $name
     * @return Helper
     */
    public function get(string $name): Helper
    {
        return $this->helpers[$name] ?? new Helper\Dummy;
    }

    /**
     *
     * @param string $name
     * @param Helper $helper
     * @return Store
     */
    public function register(string $name, Helper $helper): Store
    {
        $this->helpers[$name] = $helper;
        return $this;
    }

    /**
     *
     * @param string $name
     * @return Store
     */
    public function unregister(string $name): Store
    {
        unset($this->helpers[$name]);
        return $this;
    }

}
