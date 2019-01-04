<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Helper\Inheritance;

// [imports]
use Ra5k\Handlebars\{Flow};


/**
 *
 *
 *
 */
final class Node
{
    /**
     * @var bool
     */
    private $valid;
    
    /**
     * @var self
     */
    private $base;
    
    /**
     * @var Flow[]
     */
    private $blocks;
    
    /**
     * 
     */
    public function __construct(bool $valid = true)
    {
        $this->valid = $valid;
        $this->blocks = [];
    }
    
    /**
     * @param string $name
     * @return Flow
     */
    public function closest(string $name): Flow
    {
        $flow = null;
        $node = $this;
        while ($node) {
            $block = $node->block($name);
            if ($block->isValid()) {
                $flow = $block;
                break;
            }
            $node = $node->base;
        }
        return $flow ?: new Flow\Dummy;
    }
    
    /**
     * @param self $base
     * @return self
     */
    public function extend(self $base): self
    {
        $this->base = $base;
        return $base;
    }

    /**
     * @param string $block
     * @param Flow $flow
     * @return self
     */
    public function register(string $block, Flow $flow): self
    {
        $this->blocks[$block] = $flow;
        return $this;
    }
    
    /**
     * @param string $block
     * @return bool
     */
    public function has(string $block): bool
    {
        return isset($this->blocks[$block]);
    }
    
    /**
     * @param string $name
     * @return Flow
     */
    public function block(string $name): Flow
    {
        return $this->blocks[$name] ?? new Flow\Dummy;
    }
    
    /**
     * @return self
     */
    public function base(): self
    {
        return $this->base ?: new self(false);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }
    
    /**
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->blocks);
    }
    
}
