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
final class Parsed implements Ast
{
    /**
     * @var Script
     */
    private $source;

    /**
     * @var Node
     */
    private $root;

    /**
     * @param Script $source
     * @param Node $root
     */
    public function __construct(Script $source, Node $root)
    {
        $this->source = $source;
        $this->root = $root;
    }

    /**
     * @return Node
     */
    public function root(): Node
    {
        return $this->root;
    }

    /**
     * @return Script
     */
    public function source(): Script
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return true;
    }

}
