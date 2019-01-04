<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Parser\Csr;

// [imports]

/**
 * 
 *
 *
 */
final class CsHandlebars
{
    use CsElement;
    
    /**
     * @param Token $token
     * @return Packet
     */
    public function parse(Token $token): Packet
    {
        $offset = $token->offset();
        $position = $offset;
        $children = [];
        
        while ($token->isValid()) {
            $position = $token->offset();
            $type = $token->type();
            if ($type == Token::T_OPEN) {
                $packet = $this->element($token);
            } else if ($type == Token::T_COMMENT) {
                $packet = $this->comment($token);
            } else {
                $packet = $this->text($token);
            }
            $children[] = $packet->model();
            $token = $packet->next();
        }

        return new Packet([
            'type' => 'handlebars',
            'version' => '1',
            'offset' => $offset,
            'length' => $position - $offset,
            'elements' => $children,
        ], $token);
    }
    
}
