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
 * Array implementation of Location
 *
 *
 */
final class Arr implements Location
{
    /**
     * @var array
     */
    private $elemets;

    /**
     *
     * @param string|array $elemets
     */
    public function __construct($elemets)
    {
        if (is_array($elemets)) {
            $this->elemets = array_values($elemets);
        } else {
            $this->elemets = explode('/', $elemets);
        }
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
     * @return string
     */
    public function str(): string
    {
        return implode('/', $this->elemets);
    }

    /**
     * @return array
     */
    public function elements(): array
    {
        return $this->elemets;
    }

    /**
     * @return bool
     */
    public function isAbsolute(): bool
    {
        return (count($this->elemets) > 0 && $this->elemets[0] == '');
    }

    /**
     * @return self
     */
    public function asDirectory(): Location
    {
        $elements = $this->elemets;
        if (empty($elements) || ($elements == [''])) {
            $dir = new self(['','']);
        } else {
            $last = end($elements);
            if ($last == '') {
                $dir = $this;
            } else {
                $elements[] = '';
                $dir = new self($elements);
            }
        }
        return $dir;
    }

    /**
     * @return Location
     */
    public function normalize(): Location
    {
        $elements = [];
        $different = false;
        $last = count($this->elemets) - 1;
        //
        foreach ($this->elemets as $i => $e) {
            if ($e == '.' || ($e == '' && 0 < $i && $i < $last)) {
                $different = true;
                continue;
            } elseif ($e == '..' && !empty($elements) && end($elements)) {
                $different = true;
                array_pop($elements);
            } else {
                array_push($elements, $e);
            }
        }
        return ($different) ? new self($elements) : $this;
    }

    /**
     * @return Location
     */
    public function trap(): Location
    {
        $elements = [];
        $different = false;
        $last = count($this->elemets) - 1;
        //
        foreach ($this->elemets as $i => $e) {
            if ($e == '.' || ($e == '' && 0 < $i && $i < $last)) {
                $different = true;
                continue;
            } elseif ($e == '..') {
                if (!empty($elements) && end($elements)) {
                    $different = true;
                    array_pop($elements);
                }
            } else {
                array_push($elements, $e);
            }
        }
        return ($different) ? new self($elements) : $this;
    }

    /**
     * @param Location $ref
     * @return Location
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
                $resolved = $this->merge($this->elemets, $append);
            }
        }
        return $resolved;
    }

    /**
     * Relativizes the given Location against this Location
     *
     * @param Location $ref
     * @return Location
     *
     * @note $this = base path
     */
    public function relativize($ref): Location
    {
        /* @var $given Location */
        $given = ($ref instanceof Location) ? $ref : new self($ref);

        $prefix = $this->closed($this->elements());
        $target = $given->elements();

        // var_dump(json_encode($prefix) . ' <-> ' . json_encode($target));

        if (!$this->isPrefix($prefix, $target)) {
            $relativized = $given;
        } else {
            $tail = array_slice($target, count($prefix));
            $relativized = new self($tail);
        }

        return $relativized;
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
        return new self($elements);
    }

    /**
     *
     * @param array $path
     * @return array
     */
    private function closed(array $path): array
    {
        $last = end($path);
        while (count($path) > 1 && $last == '') {
            array_pop($path);
            $last = end($path);
        }
        return $path;
    }

    /**
     * @param array $prefix
     * @param array $target
     * @return boolean
     */
    private function isPrefix(array $prefix, array $target): bool
    {
        $match = true;
        for ($i = 0; $i < count($prefix); $i++) {
            if (!isset($target[$i]) || $prefix[$i] != $target[$i]) {
                $match = false;
                break;
            }
        }
        return $match;
    }

}
