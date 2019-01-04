<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Location;

// [imports]
use Ra5k\Handlebars\Location;


/**
 *
 *
 *
 */
final class Str implements Location
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = (string) $path;
    }

    /**
     * String-cast operator
     * @return string
     */
    public function __toString(): string
    {
        return $this->str();
    }

    /**
     * @return array
     */
    public function elements(): array
    {
        return $this->parse($this->path);
    }

    /**
     * @return bool
     */
    public function isAbsolute(): bool
    {
        return (substr($this->path, 0, 1) == '/');
    }

    /**
     * @return self
     */
    public function normalize(): Location
    {
        $elements = $this->elements();
        $normalized = [];
        $different = false;
        $last = count($elements) - 1;
        //
        foreach ($elements as $i => $e) {
            if ($e == '.' || ($e == '' && 0 < $i && $i < $last)) {
                $different = true;
                continue;
            } elseif ($e == '..' && !empty($elements) && end($elements)) {
                $different = true;
                array_pop($normalized);
            } else {
                array_push($normalized, $e);
            }
        }
        return ($different) ? new self($this->render($normalized)) : $this;
    }

    /**
     * @return self
     */
    public function trap(): Location
    {
        $elements = $this->elements();
        $normalized = [];
        $different = false;
        $last = count($elements) - 1;
        //
        foreach ($elements as $i => $e) {
            if ($e == '.' || ($e == '' && 0 < $i && $i < $last)) {
                $different = true;
                continue;
            } elseif ($e == '..') {
                if (!empty($elements) && end($elements)) {
                    $different = true;
                    array_pop($normalized);
                }
            } else {
                array_push($normalized, $e);
            }
        }
        return ($different) ? new self($this->render($normalized)) : $this;
    }

    /**
     * @param string|Location $ref
     */
    public function resolve($ref): Location
    {
        /* @var $given Location */
        $given = ($ref instanceof Location) ? $ref : new self($ref);
        //
        if ($given->isAbsolute()) {
            $resolved = $given;
        } else {
            $append = $given->elements();
            if (empty($append)) {
                $resolved = $this;
            } else {
                $resolved = $this->merge($this->elements(), $append);
            }
        }
        return $resolved;
    }

    /**
     * @param string|Location $ref
     */
    public function relativize($ref): Location
    {
        /* @var $given Location */
        $given = ($ref instanceof Location) ? $ref : new self($ref);

        $prefix = rtrim($this->str(), '/') . '/';
        $target = $given->str();
        $length = strlen($prefix);

        if (substr($target, 0, $length) != $prefix) {
            $relativized = $given;
        } else {
            $relativized = new self(substr($target, $length));
        }

        return $relativized;
    }

    /**
     *
     * @return string
     */
    public function str(): string
    {
        return $this->path;
    }


    /**
     * @return self
     */
    public function asDirectory(): Location
    {
        if (substr($this->path, -1) == '/') {
            $dir = $this;
        } else {
            $path = $this->path . '/';
            $dir = new self($path);
        }
        return $dir;
    }

    /**
     * @param array $head
     * @param array $tail
     * @return self
     */
    private function merge(array $head, array $tail): self
    {
        array_pop($head);
        $merged = array_merge($head, $tail);
        $last = count($merged) - 1;
        //
        $elements = [];
        foreach ($merged as $i => $e) {
            if ($e == '.' || ($e == '' && 0 < $i && $i < $last)) {
                continue;
            } elseif ($e == '..') {
                array_pop($elements);
            } else {
                array_push($elements, $e);
            }
        }
        return new self($this->render($elements));
    }

    /**
     * @param array $path
     * @return string
     */
    private function render(array $path): string
    {
        return implode('/', $path);
    }

    /**
     * @param string $path
     * @return array
     */
    private function parse($path): array
    {
        return explode('/', $path);
    }

}
