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
use Ra5k\Handlebars\{Script};

/**
 *
 *
 *
 */
final class Memory implements Script
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $hash;
    
    /**
     * @var string
     */
    private $content;
        
    /**
     * @param string $content
     */
    public function __construct(string $content, string $name = '')
    {
        $this->content = $content;
        $this->name = $name;
    }

    public function id(): string
    {
        return $this->hash();
    }

    public function name(): string
    {
        return $this->name ?: $this->hash();
    }
    
    public function content(): string
    {
        return $this->content;
    }

    public function exists(): bool
    {
        return true;
    }
    
    private function hash(): string
    {
        if ($this->hash === null) {
            $this->hash = sha1($this->content);
        }
        return $this->hash;
    }
    
}
