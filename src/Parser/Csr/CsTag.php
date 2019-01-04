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
 */
trait CsTag
{
    /**
     * @param array $node
     * @return array
     */
    private function normalizeTag(array $node)
    {
        $combined = (array) ($node['arguments'] ?? null);
        $arguments = [];
        foreach ($combined as $arg) {
            $type = $arg['type'] ?? '';
            if ($type == 'option') {
                $name = $arg['name'] ?? '';
                $value = $arg['value'] ?? null;
                $node['options'][$name] = $value;                
            } else {
                $arguments[] = $arg;
            }
        }
        if ($arguments) {
            $node['arguments'] = $arguments;
        } else {
            unset ($node['arguments']);
        }
        return $node;
    }
    
}
