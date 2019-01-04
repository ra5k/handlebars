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
final class CsInclude
{
    // [traits]
    use CsCommon, CsTag;
    
    /**
     * @param Token $start
     * @return Packet
     * @throws ParseError
     */
    public function parse(Token $start): Packet
    {
        $first = $this->eatSpace($start->next()->next());
        $args = (new CsArguments(false))->parse($first);
        $argv = (array) $args->model();
        $prim = array_shift($argv);
        $after = $args->next();
        $node  = $this->normalizeTag([
            'type' => 'include',
            'offset' => $start->offset(),
            'length' => $after->offset() - $start->offset(),
            'include' => $prim,
            'arguments' => $argv,
        ]);
        return new Packet($node, $after);
    }
    
}
