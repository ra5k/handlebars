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
trait CsElement
{
    /**
     * 
     * @param Token $open
     * @return Packet
     */
    private function element(Token $open)
    {
        $packet = null;
        if ($open->content() == '{{') {
            $next = $open->next();
            $open = new TkPair($open, $next);
            if ($next->type() == Token::T_SYMBOL) {
                $sym = $next->content();                
                if ($sym == '#') {
                    $packet = (new CsBlock)->parse($open);                
                } else if ($sym == '>') {
                    $packet = (new CsInclude)->parse($open);
                } else if ($sym == '^') {
                    $packet = (new CsBlock('inverse'))->parse($open);                
                }
            }
        }
        return $packet ?: (new CsStatement)->parse($open);
    }

    /**
     * @param Token $token
     * @return Packet
     */
    private function text(Token $token)
    {
        return new Packet([
            'type' => 'text',
            'offset' => $token->offset(),
            'length' => strlen($token->content()),
            // 'content' => $token->content()
        ], $token->next());
    }

    /**
     * @param Token $token
     * @return Packet
     */
    private function comment(Token $token)
    {
        return new Packet([
            'type' => 'comment',
            'offset' => $token->offset(),
            'length' => strlen($token->content()),
            // 'content' => $token->content()
        ], $token->next());
    }
    
}
