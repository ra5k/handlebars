<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Arguments;

// [imports]
use Ra5k\Handlebars\Arguments;

/**
 *
 *
 *
 */
final class Unshifted implements Arguments
{
    /**
     * @var mixed
     */
    private $head;
    
    /**
     * @var Arguments
     */
    private $orig;
    
    /**
     * @param array $arguments
     * @param array $options
     * @param Node $node
     */
    public function __construct($head, Arguments $orig)
    {
        $this->head = $head;
        $this->orig = $orig;
    }

    public function at(int $index)
    {
        return ($index == 0) ? $this->head : $this->orig->at($index + 1);
    }

    public function vector(): array
    {
        $vector = $this->orig->vector();
        array_unshift($vector, $this->head);
        return $vector;
    }

    public function option(string $name)
    {
        return $this->orig->option($name);
    }

    public function hash(): array
    {
        return $this->orig->hash();
    }

    public function isEmpty(): bool
    {
        return false;
    }

}
