<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Helper\Inheritance;


use Ra5k\Handlebars\{Context, Flow};

/**
 *
 *
 *
 */
final class Chain
{
    /**
     * @var Node
     */
    private $head;
    
    /**
     * @var Node
     */
    private $tail;
    
    /**
     * 
     */
    public function __construct(Node $node = null)
    {
        $init = $node ?: new Node();
        $this->head = $init;
        $this->tail = $init;
    }

    /**
     * @param Node $node
     * @return self
     */
    public function extend(Node $node): self
    {        
        $this->tail = $this->tail->extend($node);
        return $this;
    }

    /**
     * 
     * @return Node
     */
    public function head(): Node
    {
        return $this->head;
    }

    /**
     * @return Node
     */
    public function tail(): Node
    {
        return $this->tail;
    }
    
    /**
     * @return int
     */
    public function length(): int
    {
        $length = 0;
        $node = $this->head();
        while ($node->isValid()) {
            // echo "(", json_encode($node->keys()), ")";
            $length++;
            $node = $node->base();
        }        
        return $length;
    }
    
}
