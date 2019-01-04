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
use Ra5k\Handlebars\{Library, Script, Location};

/**
 *
 *
 *
 */
final class Virtual implements Library
{
    /**
     * @var bool
     */
    private $sign;

    /**
     * @param bool $sign
     */
    public function __construct(bool $sign = false)
    {
        $this->sign = $sign;
    }

    /**
     * @param string $name
     * @param Script $referer
     * @return Script
     */
    public function script(string $name, Script $referer = null): Script
    {
        if ($referer) {
            $path = new Location\Str($referer->name());
            $name = $path->asDirectory()->resolve($name);
        }
        return new Script\Virtual($name, $this->sign);
    }

}
