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
 */
final class TkExpr extends TkBase
{
    /**
     * @var string
     */
    private static $pattern;

    /**
     * @var int
     */
    private $type;

    /**
     * @var int
     */
    private $content;

    /**
     * @param string $source
     * @param int $offset
     */
    public function __construct(string $source, int $offset)
    {
        parent::__construct($source, $offset);
        $matches = null;
        //
        if (preg_match($this->pattern(), $source, $matches, 0, $offset)) {
            if ($matches['CLOSE'] ?? '') {
                $this->init(self::T_CLOSE, $matches['CLOSE']);
            } else if ($matches['SPACE'] ?? '') {
                $this->init(self::T_SPACE, $matches['SPACE']);
            } else if ($matches['LITERAL'] ?? '') {
                $this->init(self::T_LITERAL, $matches['LITERAL']);
            } else if ($matches['OPERATOR'] ?? '') {
                $this->dispatch($matches['OPERATOR']);
            } else {
                $this->init(self::T_END, '');
            }
        } else {
            $this->init(self::T_END, '');
        }
    }

    /**
     * @return string
     */
    private function pattern()
    {
        if (self::$pattern === null) {
            $operator = preg_quote('!#%&\'"()*+,./;<=>@[\\]^`{|}~', '/');
            $pattern = "(?<CLOSE> \}\}\}?) | (?<SPACE> \s+) | (?<LITERAL> @?[^$operator\s]+) | (?<OPERATOR> .)";
            self::$pattern = "/$pattern/mx";
        }
        return self::$pattern;
    }

    /**
     * @param int $type
     * @param type $content
     * @return $this
     */
    private function init(int $type, string $content)
    {
        $this->type = $type;
        $this->content = $content;
        return $this;
    }

    /**
     * @param string $operator
     * @return $this
     */
    private function dispatch(string $operator)
    {
        $this->init(self::T_SYMBOL, $operator);
        if ($operator == "'") {
            $this->content = $this->forward($operator, "/(?<!\\\\)'/");
            $this->type = self::T_STRING1;
        } else if ($operator == '"') {
            $this->content = $this->forward($operator, '/(?<!\\\\)"/');
            $this->type = self::T_STRING2;
        } else if ($operator == '[') {
            $this->content = $this->forward($operator, '/(?<!\\\\)\]/');
            $this->type = self::T_WRAPPED;
        }
        return $this;
    }

    /**
     * @param string $terminator
     * @return string
     */
    private function forward(string $operator, string $terminator)
    {
        $matches = null;
        $offset = $this->offset + strlen($operator);
        if (preg_match($terminator, $this->source, $matches, PREG_OFFSET_CAPTURE, $offset)) {
            $length = $matches[0][1] + strlen($matches[0][0]) - $this->offset;
        } else {
            $length = strlen($this->source) - $this->offset;
        }
        return substr($this->source, $this->offset, $length);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return ($this->type != self::T_END);
    }

    /**
     *
     * @return Token
     */
    public function next(): Token
    {
        if ($this->type == self::T_END) {
            $token = new TkEnd();
        } else if ($this->type == self::T_CLOSE) {
            $close = new TkClose($this->source, $this->offset, $this->content);
            $token = $close->next();
        } else {
            $token = new self($this->source, $this->offset + strlen($this->content));
        }
        return $token;
    }

    /**
     *
     * @return int
     */
    public function type(): int
    {
        return $this->type;
    }

    /**
     *
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }


}
