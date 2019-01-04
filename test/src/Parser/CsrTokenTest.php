<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ra5k\Handlebars\Test\Parser;

// [imports]
use Ra5k\Handlebars\Test\BaseTestCase;
use Ra5k\Handlebars\Parser;


/**
 *
 *
 *
 */
final class CsrTokenTest extends BaseTestCase
{

    /**
     *
     */
    public function testTokens1()
    {
        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        $hbs = "abc{{ N.[12].X ('quoted text') a = \"blah\" }}def{{{ht.ml}}}ghi{{}}jkl'mno {{!-- Hello --}} EOF";
        // $hbs = "abc";
        $start = new Parser\Csr\TkStart($hbs, 0);

        echo PHP_EOL;
        $token = $start->next();
        while ($token->isValid()) {
            echo json_encode($token->dump(), $flags), PHP_EOL;
            $token = $token->next();
        }

    }

}
