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
use Ra5k\Handlebars\{Parser, Script};


/**
 *
 *
 *
 */
final class CsrParserTest extends BaseTestCase
{

    public function testInline1()
    {
        $this->markTestSkipped('must be revisited.');
        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        $parser = new Parser\Csr();
        $script = new Script\Memory("AA{{ a.[b] }}BB{{{ uu }}}CC");

//        echo PHP_EOL;
//        $p = $parser->model($script);
//        echo json_encode($p->root()->dump(), $flags);
    }

    /**
     *
     */
    public function testInline2()
    {
        $this->markTestSkipped('must be revisited.');

        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        $parser = new Parser\Csr();
        $script = new Script\Memory("abc {{ author (tr 'TITLE') }} def {{#tr x=42}} ghi {{else}} jkl {{/tr}} mno {{> layout x=1}} pqr {{! COMMENT }} END");

//        echo PHP_EOL;
//        $p = $parser->model($script);
//        echo json_encode($p->root()->dump(), $flags);
    }

    /**
     *
     */
    public function testInline3()
    {
        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        $parser = new Parser\Csr();
        $script = new Script\Memory("ABC-{{include 'partial' prefix=(join abc) }}-XYZ");

        echo PHP_EOL;
        $p = $parser->model($script);
        echo json_encode($p->root()->dump(), $flags);
    }
    
    /**
     * @skip
     */
    public function testBlock()
    {
        // $this->markTestSkipped('must be revisited.');

        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
        $parser = new Parser\Csr();
        $script = new Script\Memory(
              "<ul>\n"
            . "  {{#each items}}\n"
            . "  <li>{{.}}</li>\n"
            . "  {{/each}}\n"
            . "</ul>\n"
        );
//        echo PHP_EOL;
//        $p = $parser->model($script);
//        echo json_encode($p->root()->dump(), $flags);
    }

}
