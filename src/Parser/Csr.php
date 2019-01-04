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
 * A cursor-based parser
 *
 *
 */
final class Csr implements Parser
{

    /**
     * @param Script $script
     * @return Ast
     */
    public function model(Script $script): Ast
    {
        $source = $script->content();
        $init  = new Csr\TkStart($source, 0);
        $first = $init->next();
        $stmt  = new Csr\CsHandlebars();
        $tree  = $stmt->parse($first);
        $trans = new Csr\TrSpaces($source);
        $root  = new Node\Arr($trans->transform($tree->model()));
        return new Ast\Parsed($script, $root);
    }

}
