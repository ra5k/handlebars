<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Ast;

// [imports]
use Ra5k\Handlebars\{Ast, Ast\Node, Script, Parser};

/**
 *
 *
 *
 */
final class Deferred implements Ast
{
    /**
     * @var Script
     */
    private $source;

    /**
     * @var Ast
     */
    private $model;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param Script $source
     * @param Parser $parser
     */
    public function __construct(Script $source, Parser $parser)
    {
        $this->source = $source;
        $this->parser = $parser;
    }

    /**
     * @return Node
     */
    public function root(): Node
    {
        if ($this->model === null) {
            $this->model = $this->parser->model($this->source());
        }
        return $this->model->root();
    }

    /**
     * @return Script
     */
    public function source(): Script
    {
        return $this->source;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return true;
    }


}
