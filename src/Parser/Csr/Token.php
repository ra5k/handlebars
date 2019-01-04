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
 */
interface Token
{
    const T_NULL    =  0; // empty token
    const T_END     = -1; // empty end token
    const T_TEXT    = 1;  // text content
    const T_OPEN    = 2;  // {{ or {{{ or {{&
    const T_CLOSE   = 3;  // }} or }}}
    const T_SYMBOL  = 4;  // symbol
    const T_SPACE   = 5;  // whitespace chars
    const T_LITERAL = 6;  // an expression literal
    const T_STRING1 = 7;  // single quoted string
    const T_STRING2 = 8;  // double quoted string
    const T_WRAPPED = 9;  // enclosed in square brackets
    const T_COMMENT = 10; // mustache comment   

    /**
     * @return bool
     */
    public function isValid(): bool;
    
    /**
     * @return int
     */
    public function type(): int;
    
    /**
     * @return string
     */
    public function content(): string;
    
    /**
     * @return int
     */
    public function offset(): int;
    
    /**
     * @return Token
     */
    public function next(): self;

    /**
     * @return array
     */
    public function dump(): array;
    
    /**
     * @return string
     */
    public function source(): string;
    
}
