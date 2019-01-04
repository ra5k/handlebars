<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ra5k\Handlebars\Flow;

// [imports]
use Ra5k\Handlebars\{Flow, Context};


/**
 *
 *
 *
 */
final class Dummy implements Flow
{
    
    public function alt(Context $context)
    {
        return null;
    }

    public function exec(Context $context)
    {
        return null;
    }

    public function isValid(): bool
    {
        return false;
    }

    public function load(string $name): Flow
    {
        return $this;
    }

    public function params(): array
    {
        return [];
    }

    public function withParams(array $params): Flow
    {
        return $this;
    }

}
