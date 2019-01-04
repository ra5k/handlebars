<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Ast;

// [imports]
use Ra5k\Handlebars\{Ast, Ast\Node, Script};

/**
 *
 *
 *
 */
final class Dummy implements Ast
{

    public function exists(): bool
    {
        return false;
    }

    public function root(): Node
    {
        return new Node\Dummy();
    }

    public function source(): Script
    {
        return new Script\Dummy();
    }

}
