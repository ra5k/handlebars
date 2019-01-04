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
class Wrap implements Context
{
    /**
     * @var Context
     */
    private $origin;

    public function data()
    {
        return $this->origin->data();
    }

    public function exists(): bool
    {
        return $this->origin->exists();
    }

    public function child($data): Context
    {
        return $this->origin->child($data);
    }

    public function parent(): Context
    {
        return $this->origin->parent();
    }

    public function node(array $path): Context
    {
        return $this->origin->node($path);
    }

}
