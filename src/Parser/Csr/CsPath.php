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
final class CsPath
{
    /**
     * @param Token $token
     * @return Packet
     */
    public function parse(Token $token): Packet
    {
        $path = [];
        $name = '';
        //
        while ($token->isValid()) {
            $type = $token->type();
            $str = $token->content();
            if ($type == Token::T_CLOSE || $type == Token::T_SPACE) {
                break;
            } else if ($type == Token::T_SYMBOL) {
                if ($this->processSymbol($token, $path)) {
                    break;
                }
                $name .= $str;
            } else if ($type == Token::T_LITERAL) {
                $path[] = $str;
                $name .= $str;
            } else if ($type == Token::T_WRAPPED) {
                $key = $this->unwrapString($str);
                $path[] = $key;
                $name .= $key;
            } else {
                throw new ParseError($token, "Unexpected token [$str]");
            }
            $token = $token->next();
        }
        $this->checkPath($name, $path, $token);
        return new Packet(['type' => 'path', 'name' => $name, 'path' => $path], $token);
    }

    /**
     * @param Token $token
     * @param array $path
     * @return boolean
     * @throws ParseError
     */
    private function processSymbol(Token $token, array $path)
    {
        $done = false;
        $str = $token->content();
        if ($str == '/' || $str == '.') {
            // pass;
        } else {
            $done = true;
        }
        return $done;
    }

    /**
     * @param string $string
     * @return string
     */
    private function unwrapString(string $string)
    {
        $value = rtrim(ltrim($string, '['), ']');
        return is_numeric($value) ? $value + 0 : $value;
    }

    /**
     * @param string $name
     * @param array $path
     * @param Token $token
     * @throws ParseError
     */
    private function checkPath($name, $path, Token $token)
    {
        if (empty($name)) {
            throw new ParseError($token, "Path must not be empty");
        }
    }
    
}
