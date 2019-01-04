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
final class TrSpaces
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
        $this->transChildren($node, 'elements');
        return $node;
    }

    /**
     * 
     * @param array $node
     * @param string $key
     * @return array
     */
    private function transChildren(array & $node, string $key)
    {
        $children =& $node[$key];        
        $prev = null;
        foreach ($children as & $node) {
            if ($this->type($node) == 'block' && $this->type($prev) == 'text') {
                if (isset($node['elements'])) {                    
                    $this->cleanBlockStart($node, $prev, 'elements');
                    $this->transChildren($node, 'elements');
                }
                if (isset($node['alternatives'])) {
                    $this->cleanBlockStart($node, $prev, 'alternatives');
                    $this->transChildren($node, 'alternatives');
                }
            } else if ($this->type($node) == 'text' && ($this->type($prev) == 'block')) {
                if (isset($prev['elements'])) {
                    $this->cleanBlockEnd($prev, $node, 'elements');
                }
                if (isset($prev['alternatives'])) {
                    $this->cleanBlockEnd($prev, $node, 'alternatives');
                }
            }
            $prev =& $node;
        }
    }
    
    private function cleanBlockStart(& $block, & $before, $key)
    {
        $elements =& $block[$key];
        //        
        if (isset($elements[0]) && $this->type($elements[0]) == 'text') {
            $first =& $elements[0];
            $m1 = null;
            $m2 = null;
            $b = $this->content($before);
            $f = $this->content($first);
            if (preg_match('/\R(\h+)$/', $b, $m1) && preg_match('/^\h*\R/', $f, $m2)) {
                $before['length'] -= strlen($m1[1]);
                $first['offset'] += strlen($m2[0]);
                $first['length'] -= strlen($m2[0]);
            }
        }
    }
    
    private function cleanBlockEnd(& $block, & $after, $key)
    {
        $elements =& $block[$key];
        $end = count($elements) - 1;        
        if (isset($elements[$end]) && $this->type($elements[$end]) == 'text') {
            $last =& $elements[$end];
            $m1 = null;
            $m2 = null;
            $a = $this->content($after);
            $l = $this->content($last);
            if (preg_match('/\R(\h+)$/', $l, $m1) && preg_match('/^\h*\R/', $a, $m2)) {
                $last['length'] -= strlen($m1[1]);
                $after['offset'] += strlen($m2[0]);
                $after['length'] -= strlen($m2[0]);
            }            
        }
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
     * @param string $key
     * @return array
     */
    private function content($text)
    {
        if (isset($text['offset'])) {
            if (isset($text['length'])) {
                $content = substr($this->source, $text['offset'], $text['length']);
            } else {
                $content = substr($this->source, $text['offset']);
            }
        } else {
            $content = $this->source;
        }
        return $content;
    }
    
    
}
