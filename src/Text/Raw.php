<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 GitHub/ra5k
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Text;

// [imports]
use Ra5k\Handlebars\Text;

/**
 *
 *
 *
 */
final class Raw implements Text
{
    /**
     * @var mixed
     */
    private $value;
    
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }
    
    /**
     * @return string
     */
    public function toString(): string
    {
        $value = $this->value;
        return ($value instanceof Text) ? $value->toString() : strval($value);
    }

}
