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
 *
 *
 */
interface Context
{
    /**
     * Returns true, if this node represents an existing variable
     * @return bool
     */
    public function exists(): bool;

    /**
     * Returns the inner data
     * @return mixed
     */
    public function data();

    /**
     * @return self
     */
    public function parent(): self;

    /**
     * @param mixed $data
     * @return self
     */
    public function child($data): self;

    /**
     * Returns a descendant node
     *
     * @param array $path
     * @return static
     */
    public function node(array $path): self;

}
