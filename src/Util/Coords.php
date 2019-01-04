<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Util;


/**
 *
 *
 *
 */
final class Coords
{
    /**
     * @var string
     */
    private $source;
    
    /**
     * @var int
     */
    private $offset;
    
    /**
     * @var int
     */
    private $line;
    
    /**
     * @var int
     */
    private $column;
    
    /**
     * @param string $source
     */
    public function __construct(string $source, int $offset)
    {
        $this->source = $source;
        $this->offset = $offset;
        if ($offset > strlen($source)) {
            $this->line = -1;
            $this->column = -1;
        }
    }

    /**
     * @return int
     */
    public function line(): int
    {
        if ($this->line === null) {
            $this->find();
        }
        return $this->line;
    }
    
    /**
     * @return int
     */
    public function column(): int
    {
        if ($this->column === null) {
            $this->find();
        }
        return $this->column;
    }

    /**
     * 
     */
    private function find()
    {
        $this->line = 1;
        $matches = null;
        $offset = 0;
        //
        while (preg_match('/\R/', $this->source, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $next = $matches[0][1];
            $width = strlen($matches[0][0]);
            if ($next > $this->offset) {
                break;
            }            
            $this->line++;
            $offset = $next + $width;
        }
        $this->column = 1 + $this->offset - $offset;
    }
    
}
