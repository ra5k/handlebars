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
final class TkPair implements Token
{
    /**
     * @var Token
     */
    private $origin;
    
    /**
     * @var self
     */
    private $next;
    
    /**
     * @param Token $current
     */
    public function __construct(Token $current, Token $next)
    {
        $this->origin = $current;
        $this->next = $next;
    }

    public function content(): string
    {
        return $this->origin->content();
    }

    public function dump(): array
    {
        return $this->origin->dump();
    }

    public function isValid(): bool
    {
        return $this->origin->isValid();
    }

    public function next(): Token
    {
        return $this->next;
    }

    public function offset(): int
    {
        return $this->origin->offset();
    }

    public function length(): int
    {
        return $this->origin->length();
    }
    
    public function source(): string
    {
        return $this->origin->source();
    }

    public function type(): int
    {
        return $this->origin->type();
    }

}
