<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 GitHub/ra5k
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Format;

// [imports]
use Ra5k\Handlebars\Format;

/**
 *
 *
 *
 */
final class Html implements Format
{
    /**
     * @var int
     */
    private $flags;

    /**
     * @var string
     */
    private $encodig;

    /**
     * @param int $flags
     * @param string $encodig
     */
    public function __construct(int $flags = null, string $encodig = null)
    {
        $this->flags = $flags ?? ENT_COMPAT | ENT_HTML5;
        $this->encodig = $encodig ?? ini_get('default_charset');
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function text($value): string
    {
        return htmlspecialchars($value, $this->flags, $this->encodig);
    }
    
}
