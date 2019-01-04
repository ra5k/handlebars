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
final class Dummy implements Library
{

    /**
     * 
     * @param string $name
     * @return Script
     */
    public function script(string $name, Script $referer = null): Script
    {
        return new Script\Dummy();
    }

}
