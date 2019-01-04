<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Script;

// [imports]
use Ra5k\Handlebars\Script;


/**
 *
 *
 *
 */
final class Dummy implements Script
{

    public function id(): string
    {
        return '';
    }

    public function name(): string
    {
        return '';
    }

    public function content(): string
    {
        return '';
    }

    public function exists(): bool
    {
        return false;
    }

}
