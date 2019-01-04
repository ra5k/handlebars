<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Context;

// [imports]
use Ra5k\Handlebars\Context;


/**
 *
 *
 *
 */
final class Dummy implements Context
{

    public function data()
    {
        return null;
    }

    public function exists(): bool
    {
        return false;
    }

    public function node(array $path): Context
    {
        return $this;
    }

    public function parent(): Context
    {
        return $this;
    }

    public function child($data): Context
    {
        return $this;
    }

}
