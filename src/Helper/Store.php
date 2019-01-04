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
use Ra5k\Handlebars\Helper;
use IteratorAggregate;

/**
 *
 *
 */
interface Store extends IteratorAggregate
{

    /**
     * @param string $name
     * @return Helper
     */
    public function get(string $name): Helper;

    /**
     * @param string $name
     * @param Helper $helper
     * @return self
     */
    public function register(string $name, Helper $helper): self;

    /**
     * @param string $name
     * @return self
     */
    public function unregister(string $name): self;

}
