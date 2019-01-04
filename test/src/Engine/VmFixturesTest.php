<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Test\Engine;

// [imports]
use Ra5k\Handlebars\{Engine, Library, Script, Helper, Text};
use Ra5k\Handlebars\Exception;
use PHPUnit\Framework\TestCase;
use Iterator, FilesystemIterator;

/**
 *
 *
 *
 */
final class VmFixturesTest extends TestCase
{

    public function testExecError()
    {
        $this->expectException(Exception::class);
        $library = new Library\Dummy();
        $engine = new Engine\Vm($library);
        $script = new Script\Memory('{{#no-helper 123}}');
        $engine->template($script);
    }

    /**
     * @dataProvider fixtures
     */
    public function testCompile($path, $source, $context, $expected)
    {
        $library = new Library\Files($path);
        $engine = new Engine\Vm($library);

        $engine->helpers()
            ->register('date', new Helper\Callback(function ($args) {
                return date($args->at(1));
            }))
            ->register('resolve', new Helper\Callback(function ($args) {
                return $args->at(1);
            }))
            ->register('raw', new Helper\Callback(function ($args) {
                return new Text\Raw($args->at(1));
            }))
            ->register('join', new Helper\Callback(function ($args) {
                $glue = $args->option('glue') ?: ' ';
                $parts = $args->vector();
                array_shift($parts);                
                return implode($glue, $parts);
            }))            
        ;
        
        $script = $library->script($source);
        $template = $engine->template($script);

        ob_start();
        $template->write($context);
        $output = ob_get_clean();

        file_put_contents("$path/output.txt", $output);
        $this->assertXmlStringEqualsXmlString($expected, $output);
    }

    /**
     *
     * @return Iterator
     */
    public function fixtures(): Iterator
    {
        $flags = FilesystemIterator::SKIP_DOTS;
        $directory = new FilesystemIterator(TEST_PATH . '/fixtures', $flags);
        foreach ($directory as $info) {
            if (!$info->isDir()) {
                continue;
            }
            $key = $info->getBasename();
            $base = $info->getPathname();
            $source = "source";
            $context = $this->include("$base/context.php");
            $expected = $this->contents("$base/expected.xml");
            if ($expected && file_exists("$base/source.hbs")) {
                yield $key => [$base, $source, $context, $expected];
            }
        }
    }

    private function contents($path)
    {
        return file_exists($path) ? file_get_contents($path) : null;
    }

    private function include($path)
    {
        return file_exists($path) ? include($path) : null;
    }

}
