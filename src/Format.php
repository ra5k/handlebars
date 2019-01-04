<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 GitHub/ra5k
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars;


/**
 *
 *
 */
interface Format
{

    /**
     * Returns a textual representation of the input $value
     * 
     * @param mixed $value
     * @return string
     */
    public function text($value): string;
    
}
