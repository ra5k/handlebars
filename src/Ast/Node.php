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
use Iterator;

/**
 * A node of an abstract syntax tree (AST)
 *
 */
interface Node
{

    /**
     * @return string
     */
    public function type(): string;

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function prop(string $name, $default = null);

    /**
     * @return Iterator
     */
    public function elements(): Iterator;

    /**
     * @return Iterator
     */
    public function alternatives(): Iterator;

    /**
     *
     * @return array
     */
    public function dump(): array;

}
