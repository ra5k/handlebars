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
final class TkStart extends TkBase
{
    /**
     * @return int
     */
    public function type(): int
    {
        return self::T_NULL;
    }
    
    /**
     * 
     * @return string
     */
    public function content(): string
    {
        return '';
    }

    /**
     * 
     * @return Token
     */
    public function next(): Token
    {
        $offset = $this->offset;
        //
        if ($offset < strlen($this->source)) {
            $matches = null;
            $offset = $this->offset;
            if (preg_match('/\G\{\{[\{&!]?/', $this->source, $matches, 0, $offset)) {
                if ($matches[0] == '{{!') {
                    $token = new TkComment($this->source, $offset);
                } else {
                    $token = new TkOpen($this->source, $offset, $matches[0]);
                }                
            } else {
                $token = new TkText($this->source, $offset);
            }
        } else {
            $token = new TkEnd();
        }
        return $token;
    }

}
