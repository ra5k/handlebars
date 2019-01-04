<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Library;


// [imports]
use Ra5k\Handlebars\{Library, Script};


/**
 *
 *
 *
 */
final class Multi implements Library
{
    /**
     * @var array
     */
    private $routes;

    /**
     * @var Library
     */
    private $base;

    /**
     *
     */
    public function __construct(array $routes = [], Library $base = null)
    {
        $this->routes = $routes;
        $this->base = $base ?: new Library\Virtual(true);
    }

    /**
     * @param string $name
     * @param Script $referer
     * @return Script
     */
    public function script(string $name, Script $referer = null): Script
    {
        $script = $this->base->script($name, $referer);
        if ($script->exists()) {
            $script = $this->find($script->name());
        }
        return $script ?: new Script\Dummy();
    }

    /**
     * @param string $prefix
     * @param Library $library
     * @return self
     */
    public function add(string $prefix, Library $library): self
    {
        $this->routes[$prefix][] = $library;
        return $this;
    }

    /**
     * @param string $path
     * @return Script|null
     */
    private function find(string $path, Script $referer = null)
    {
        $script = null;
        foreach ($this->routes as $prefix => $chain) {
            $length = strlen($prefix);
            if (substr($path, 0, $length) == $prefix) {
                $script = $this->first($chain, substr($path, $length), $referer);
                break;
            }
        }
        return $script;
    }

    /**
     * @param array $chain
     * @param string $name
     * @param Script|null $referer
     * @return Script|null
     */
    private function first(array $chain, $name, $referer)
    {
        $script = null;
        foreach ($this->reverse($chain) as $library) {
            /* @var $library Library */
            $script = $library->script($name, $referer);
            if ($script->exists()) {
                break;
            }
        }
        return $script;
    }

    /**
     * @param array $items
     */
    private function reverse(array $items)
    {
        $c = end($items);
        while ($c !== false) {
            yield $c;
            $c = prev($items);
        }
    }

}