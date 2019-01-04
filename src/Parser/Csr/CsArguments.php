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
final class CsArguments
{
    use CsCommon;

    /**
     * @var bool
     */
    private $sub;
    
    /**
     * @param bool $sub
     */
    public function __construct(bool $sub = false)
    {
        $this->sub = $sub;
    }

    /**
     *
     * @param Token $token
     * @return Packet
     */
    public function parse(Token $token): Packet
    {
        $arguments = [];
        while ($token->isValid()) {
            $type = $token->type();
            if ($type == Token::T_CLOSE) {
                $token = $token->next();
                break;
            } else if ($type == Token::T_SPACE) {
                $token = $token->next();
            } else if ($type == Token::T_SYMBOL) {
                $packet = $this->processSymbol($token, $arguments);
                $token = $packet->next();
                $done = $packet->model();
                if ($done) {
                    break;
                }
            } else {
                $packet = $this->parseValue($token);
                $arguments[] = $packet->model();
                $token = $packet->next();
            }
        }
        return new Packet($arguments, $token);
    }
    
    /**
     * @param Token $token
     * @param array $arguments
     * @return Packet
     * @throws ParseError
     */
    private function processSymbol(Token $token, array &$arguments)
    {
        $done = false;
        $sym = $token->content();
        if ($sym == '(') {
            $packet = (new CsStatement(true))->parse($token);
            $arguments[] = $packet->model();
            $token = $packet->next();
        } else if ($sym == ')') {
            if ($this->sub) {
                $token = $token->next();
                $done = true;                
            } else {
                throw new ParseError($token, "Unexpected token [$sym]");
            }
        } else if ($sym == '=') {
            $last = array_pop($arguments);
            $key = $this->argumentKey($last, $token);
            if (!$key) {
                throw new ParseError($token, "Attribute name is missing");
            }
            $packet = $this->parseValue($this->eatSpace($token->next()));
            $token = $packet->next();
            $arguments[] = ['type' => 'option', 'name' => $key, 'value' => $packet->model()];
        } else {
            throw new ParseError($token, "Unexpected token [$sym]");
        }
        return new Packet($done, $token);
    }
    
    /**
     * @param Token $token
     * @return Packet
     */
    private function parseValue(Token $token): Packet
    {
        $argument = null;
        if ($token->isValid()) {
            $type = $token->type();
            $str  = $token->content();
            if ($type == Token::T_STRING1) {
                $argument = $this->unquoteString($str, "'");
                $token = $token->next();
            } else if ($type == Token::T_STRING2) {
                $argument = $this->unquoteString($str, '"');
                $token = $token->next();
            } else if ($type == Token::T_LITERAL) {
                if ($this->extractInto($argument, $str)) {
                    $token = $token->next();
                } else {
                    $path = (new CsPath)->parse($token);
                    $token = $path->next();
                    $argument = $path->model();
                }
            } else if ($type == Token::T_SYMBOL && $str == '(' ) {
                $packet = (new CsStatement(true))->parse($token);
                $argument = $packet->model();
                $token = $packet->next();                
            } else {
                throw new ParseError($token, "Unexpected token [$str/$type]");
            }
        }
        return new Packet($argument, $token);
    }

    /**
     * @param mixed $buffer
     * @param string $literal
     * @return boolean
     */
    private function extractInto(&$buffer, $literal)
    {
        $match = true;
        if ($literal == 'true') {
            $buffer = true;
        } else if ($literal == 'false') {
            $buffer = false;
        } else if ($literal == 'null') {
            $buffer = null;
        } else if (is_numeric($literal)) {
            $buffer = $literal + 0;
        } else {
            $match = false;
        }
        return $match;
    }

    /**
     * @param string $string
     * @param string $quote
     * @return string
     */
    private function unquoteString(string $string, string $quote)
    {
        $inner = trim($string, $quote);
        return str_replace("\\{$quote}", $quote, $inner);
    }

    /**
     * @param mixed $argument
     * @return string
     */
    private function argumentKey($argument, Token $token)
    {
        $key = '';
        if (is_scalar($argument)) {
            $key = (string) $argument;
        } else if (is_array($argument)) {
            $type = $argument['type'] ?? '?';
            if ($type == 'path') {
                $path = (array) ($argument['path'] ?? null);
                if (count($path) > 1) {
                    throw new ParseError($token, "Composite keys are not supported");
                }                
                $key = (string) $path[0] ?? '';
            }
        }
        return $key;
    }
    
}
