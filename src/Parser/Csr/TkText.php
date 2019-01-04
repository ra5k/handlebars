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
final class TkText extends TkBase
{
    /**
     * @var string
     */
    private $content;
    
    /**
     * @var Token
     */
    private $next;
    
    /**
     * 
     * @param string $source
     * @param int $offset
     */
    public function __construct(string $source, int $offset)
    {
        parent::__construct($source, $offset);
        $capture = PREG_OFFSET_CAPTURE;
        $matches = null;
        if (preg_match('/(?<!\\\\)\{\{[\{&!]?/', $source, $matches, $capture, $offset)) {
            $match = $matches[0][0];
            $position = $matches[0][1];
            $this->content = substr($source, $offset, $position - $offset);
            if ($match == '{{!') {
                $this->next = new TkComment($this->source, $position);
            } else {
                $this->next = new TkOpen($this->source, $position, $match);
            }            
        } else {            
            if ($offset < strlen($source)) {
                $this->content = substr($source, $offset);
                $this->next = new TkEnd();
            } else {
                $this->content = '';
                $this->next = new TkEnd();
            }
        }        
    }

    /**
     * 
     * @return int
     */
    public function type(): int
    {
        return self::T_TEXT;
    }

    /**
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * @return Token
     */
    public function next(): Token
    {
        return $this->next;
    }

}
