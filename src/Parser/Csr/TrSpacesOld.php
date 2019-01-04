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
 * @deprecated
 */
final class TrSpacesOld
{
    /**
     * @var string
     */
    private $source;
    
    /**
     * 
     * @param string $source
     */
    public function __construct(string $source)
    {
        $this->source = $source;
    }

    /**
     * @param array $node
     * @return array
     */
    public function transform(array $node)
    {
        return $this->transChildren($node, 'elements');
    }
    
    /**
     * TODO: Refactor
     * 
     * @param array $node
     */
    private function transChildren(array $node, string $key)
    {
        $children = (array) ($node[$key] ?? null);
        if ($children) {
            $children = $this->transInner($children);
        }
        //
        $pre_node = null;
        foreach ($children as $index => &$cur_node) {
            $type = $this->type($cur_node);
            if ($type == 'block') {
                $c1 = $this->transChildren($cur_node, 'elements');
                $c2 = $this->transChildren($c1, 'alternatives');
                $children[$index] = $c2;
            }
            if ($this->type($pre_node) == 'text' && $this->needsCleaning($type)) {
                $pre_node = $this->cleanTail($pre_node);
            }
            if ($this->needsCleaning($this->type($pre_node)) && $type == 'text') {
                $cur_node = $this->cleanHead($cur_node);
            }
            $pre_node =& $cur_node;
        }
        //
        if ($children) {
            $node[$key] = $children;
        }
        return $node;
    }

    /**
     * @param array $sibblings
     * @return array
     */
    private function transInner(array $sibblings)
    {
        $max = count($sibblings) - 1;
        //
        if (isset($sibblings[0])) {
            $first =& $sibblings[0];
            if ($first && $this->type($first) == 'text') {
                $first = $this->cleanHead($first);
            }
        }        
        if (isset($sibblings[$max])) {
            $last =& $sibblings[$max];
            if ($last && $this->type($last) == 'text') {
                $last = $this->cleanTail($last);
            }
        }
        return $sibblings;
    }
    
    /**
     * @param string $type
     * @return string
     */
    private function needsCleaning($type)
    {
        return ($type == 'block' || $type == 'include' || $type == 'comment');
    }
    
    /**
     * @param array $node
     * @return array
     */
    private function cleanTail($node)
    {
        $matches = null;
        $text = substr($this->source, $this->offset($node), $this->length($node));                
        if (preg_match('/\h*$/', $text, $matches)) {
            $node['length'] -= strlen($matches[0]);                    
        }
        return $node;
    }
    
    /**
     * @param array $node
     * @return array
     */
    private function cleanHead($node)
    {
        $matches = null;
        $offset = $this->offset($node);
        if (preg_match('/\G\h*\R/', $this->source, $matches, 0, $offset)) {
            $bias = strlen($matches[0]);
            $node['offset'] += $bias;
            $node['length'] -= $bias;
        }
        return $node;
    }
    
    /**
     * @param array $node
     * @return string
     */
    private function type($node)
    {
        return $node['type'] ?? '';
    }

    /**
     * @param array $node
     * @return int
     */
    private function length($node)
    {
        return (int) $node['length'] ?? 0;
    }
    
    /**
     * @param array $node
     * @return int
     */
    private function offset($node)
    {
        return (int) $node['offset'] ?? 0;
    }

}
