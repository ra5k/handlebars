<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Ast\Node;

// [imports]
use Ra5k\Handlebars\Node;
use Iterator, EmptyIterator;

/**
 *
 *
 *
 */
final class Dummy implements Node
{

    public function type(): string
    {
        return '';
    }

    public function prop(string $name, $default = null)
    {
        return $default;
    }

    public function elements(): Iterator
    {
        return new EmptyIterator();
    }

    public function alternatives(): Iterator
    {
        return new EmptyIterator();
    }

    public function dump(): array
    {
        return [];
    }

}
