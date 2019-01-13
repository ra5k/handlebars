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
use Iterator, FilesystemIterator;

/**
 *
 *
 *
 */
final class CsrFixturesTest extends BaseTestCase
{

    /**
     * @dataProvider fixtures
     */
    public function testParse($name, $source, $expected)
    {
        $script = new Script\Memory($source);
        $parser = new Parser\Csr();        
        $model = $parser->model($script);
        $actual = $model->root()->dump();
        //
        if ($expected === null) {
            $this->dump("$name: ", $actual);
        } else {
            $this->assertEquals($expected, $actual);
        }
    }

    /**
     *
     * @return Iterator
     */
    public function fixtures(): Iterator
    {
        $flags = FilesystemIterator::SKIP_DOTS;
        $directory = new FilesystemIterator(TEST_PATH . '/fixtures/parser', $flags);
        //
        foreach ($directory as $info) {
            if (!$info->isDir()) {
                continue;
            }
            $key = $info->getBasename();
            $base = $info->getPathname();            
            $source = $this->contents("$base/source.hbs");
            $expected = $this->contents("$base/expected.json");    
            $model = ($expected) ? json_decode($expected, true) : null;
            yield $key => [$key, $source, $model];
        }
    }

    
    private function contents($path)
    {
        return file_exists($path) ? file_get_contents($path) : null;
    }

    private function dump($title, $object)
    {
        $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;        
        echo $title, json_encode($object, $flags), PHP_EOL;
    }

}
