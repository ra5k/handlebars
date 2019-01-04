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
 * A language construct
 *
 */
interface Construct
{

    /**
     * @param Token $start
     * @param Token $head
     * @return Packet
     */
    public function parse(Token $start, Token $head): Packet;
    
}
