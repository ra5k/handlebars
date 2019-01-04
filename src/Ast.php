<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars;


/**
 * An abstract syntax tree
 *
 */
interface Ast
{

    /**
     * @return Ast\Node
     */
    public function root(): Ast\Node;

    /**
     * @return Script
     */
    public function source(): Script;

    /**
     * @return bool
     */
    public function exists(): bool;

}
