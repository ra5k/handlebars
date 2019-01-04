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
trait CsCommon
{
    /**
     * @param Token $token
     * @return Token
     */
    private function eatSpace(Token $token): Token
    {
        while ($token->isValid()) {
            if ($token->type() != Token::T_SPACE) {
                break;
            }
            $token = $token->next();
        }
        return $token;
    }

}
