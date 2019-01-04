<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Parser;

// [imports]
use Ra5k\Handlebars\{Parser, Script, Ast, Ast\Node};


/**
 * This instance keeps all ASTs in memory. It works similar to PHP's include_once() construct.
 *
 *
 */
final class Once implements Parser
{
    /**
     * @var Parser
     */
    private $origin;

    /**
     * @var Node[]
     */
    private $cache;

    /**
     * @param Parser $origin
     */
    public function __construct(Parser $origin)
    {
        $this->origin = $origin;
    }

    /**
     * @param Script $script
     * @return Ast
     */
    public function model(Script $script): Ast
    {
        $id = $script->id();
        if (isset($this->cache[$id])) {
            $root = $this->cache[$id];
            $model = new Ast\Parsed($script, $root);
        } else {
            $model = $this->origin->model($script);
            $this->cache[$id] = $model->root();
        }
        return $model;
    }

}
