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
interface Arguments
{

    /**
     * Returns the value at position $index
     * @param int $index
     * @return mixed
     */
    public function at(int $index);

    /**
     * Returns the argument vector (all arguments)
     * @return array
     */
    public function vector(): array;

    /**
     * Returns the value of an option
     * @param string $name
     */
    public function option(string $name);

    /**
     * Returns the option hash table (all options)
     * @return array
     */
    public function hash(): array;

}
