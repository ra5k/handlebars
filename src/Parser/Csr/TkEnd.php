<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Parser\Csr;


/**
 *
 *
 *
 */
final class TkEnd implements Token
{

    public function isValid(): bool
    {
        return false;
    }

    public function offset(): int
    {
        return -1;
    }
    
    public function type(): int
    {
        return self::T_END;
    }

    public function content(): string
    {
        return '';
    }

    public function next(): Token
    {
        return $this;
    }

    public function source(): string
    {
        return '';
    }

    public function dump(): array
    {
        return [$this->type(), $this->content(), $this->offset()];
    }

}
