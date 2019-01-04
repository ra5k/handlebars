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
final class Arr implements Arguments
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var array
     */
    private $options;

    /**
     * @param array $arguments
     * @param array $options
     */
    public function __construct(array $arguments, array $options)
    {
        $this->arguments = $arguments;
        $this->options = $options;
    }

    public function at(int $index)
    {
        return $this->arguments[$index] ?? null;
    }

    public function vector(): array
    {
        return $this->arguments;
    }

    public function option(string $name)
    {
        return $this->options[$name] ?? null;
    }

    public function hash(): array
    {
        return $this->options;
    }

}
