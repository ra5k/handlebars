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
final class CsBlock
{
    // [traits]
    use CsCommon, CsTag, CsElement;

    /**
     * @var string
     */
    private $method;
    
    /**
     * @param string $method
     */
    public function __construct(string $method = 'helper')
    {
        $this->method = $method;
    }
    
    /**
     *
     * @param Token $start
     * @param Token $head
     * @return Packet
     */
    public function parse(Token $open): Packet
    {        
        $indi = $open->next();        
        $start = $this->eatSpace($indi->next());
        $path = (new CsPath)->parse($start);
        $args = (new CsArguments)->parse($path->next());
        $name = $this->pathName($path->model());        
        $elements = $this->parseElements($args->next(), $name);
        $after = $elements->next();
        //
        $node = $this->normalizeTag([
            'type' => 'block',
            'method' => $this->method,
            'offset' => $start->offset(),
            'length' => $after->offset() - $start->offset(),
            'stmt' => $path->model(),
            'arguments' => $args->model(),
        ] + $this->placeElements($elements->model()));
        return new Packet($node, $after);
    }

    /**
     * @param Token $token
     * @param string $name
     * @return Packet
     */
    private function parseElements(Token $token, string $name)
    {
        $first = $token;
        $closed = false;
        $elements = [];
        //
        while ($token->isValid()) {
            $type = $token->type();
            if ($type == Token::T_OPEN) {
                $next = $token->next();
                $token = new TkPair($token, $next);
                if ($next->type() == Token::T_SYMBOL && $next->content() == '/') {
                    $packet = $this->parseClose($token, $name);
                    $token = $packet->next();
                    $closed = true;
                    break;
                }
                $packet = $this->element($token);
            } else if ($type == Token::T_COMMENT) {
                $packet = $this->comment($token);
            } else {
                $packet = $this->text($token);
            }
            $elements[] = $packet->model();
            $token = $packet->next();
        }
        if (!$closed) {
            throw new ParseError($first, "Missing close tag for '$name'");
        }
        return new Packet($elements, $token);
    }

    /**
     * @param Token $open
     * @param string $expected
     */
    private function parseClose(Token $open, $expected)
    {
        $slash = $open->next();
        $start = $slash->next();
        $path = (new CsPath)->parse($start);
        $name = $this->pathName($path->model());        
        if ($expected && ($name != $expected)) {
            throw new ParseError($start, "Wrong close tag '$name', expected '$expected'");
        }        
        $token = $path->next();
        while ($token->isValid()) {
            $type = $token->type();
            if ($type == Token::T_SPACE) {
                $token = $token->next();
            } else if ($type == Token::T_CLOSE) {
                $token = $token->next();
                break;
            } else {
                $str = $token->content();
                throw new ParseError($token, "Unexpected token [$str]");
            }
        }
        return new Packet($path, $token);
    }
    
    /**
     * @param array $path
     * @return string
     */
    private function pathName($path)
    {
        return (string) $path['name'] ?? '';
    }
    
    /**
     * 
     */
    private function placeElements(array $elements)
    {
        $record = [];
        $key = 'elements';
        foreach ($elements as $e) {
            $stmt = $e['stmt'] ?? null;
            $type = $stmt['type'] ?? '';
            $name = $stmt['name'] ?? '';
            if ($type == 'path' && $name == 'else') {
                $key = 'alternatives';
                continue;
            }
            $record[$key][] = $e;            
        }
        return $record;
    }
    
}
