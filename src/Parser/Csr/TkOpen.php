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
// use Ra5k\Handlebars\Exception\ContextError;

/**
 *
 *
 *
 */
final class TkOpen extends TkBase
{
    /**
     * @var string
     */
    private $content;
    
    /**
     * @param string $source
     * @param int $offset
     */
    public function __construct(string $source, int $offset, string $content)
    {
        parent::__construct($source, $offset);
        $this->content = $content;
    }

    /**
     * 
     * @return int
     */
    public function type(): int
    {
        return self::T_OPEN;
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
        $symbol = $this->content;
        $offset = $this->offset + strlen($symbol);        
        if ($offset < strlen($this->source)) {
            $matches = null;
            if (preg_match('/\G\}\}\}?/', $this->source, $matches, 0, $offset)) {
                $token = new TkClose($this->source, $offset, $matches[0]);
            } else {
                $token = new TkExpr($this->source, $offset);
            }
        } else {
            $token = new TkEnd();
        }
        return $token;
    }

}
