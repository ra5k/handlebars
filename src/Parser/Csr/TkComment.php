<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Parser\Csr;


// [imports]


/**
 *
 *
 *
 */
final class TkComment extends TkBase
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
     * @param string $source
     * @param int $offset
     */
    public function __construct(string $source, int $offset)
    {
        parent::__construct($source, $offset);
        $pattern = (substr($source, $offset, 5) == '{{!--') ? '--}}' : '}}';
        //
        $position = strpos($source, $pattern, $offset);
        if ($position !== false) {
            $end = $position + strlen($pattern);
            $pre = new TkStart($source, $end);
            $this->content = substr($source, $offset, $end - $offset);
            $this->next = $pre->next();
        } else {
            throw new ParseError($this, "Comment not closed");
        }     
    }
    
    /**
     * 
     * @return int
     */
    public function type(): int
    {
        return self::T_COMMENT;
    }

    /**
     * 
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
