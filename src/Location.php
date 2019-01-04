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
interface Location
{
    /**
     * String-cast operator
     *
     * This function must return the same result as str()
     * except that is must not throw an exception
     */
    public function __toString(): string;

    /**
     * @return bool
     */
    public function isAbsolute(): bool;

    /**
     * String-representation of the path
     */
    public function str(): string;

    /**
     * @return array
     */
    public function elements(): array;

    /**
     * @return static
     */
    public function normalize(): self;

    /**
     * @return static
     */
    public function trap(): self;

    /**
     * Resolves $tail against $this Path
     *
     * @param static|string $ref
     * @return static
     */
    public function resolve($ref): self;

    /**
     * Make $this path relative to $base
     * @param static|string $ref
     * @return static
     */
    public function relativize($ref): self;

    /**
     * Returns the path with a trailing slash
     * @return static
     */
    public function asDirectory(): self;

}
