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
use Ra5k\Handlebars\{Engine, Library, Script, Helper};
use Ra5k\Handlebars\Exception;
use PHPUnit\Framework\TestCase;


/**
 *
 *
 *
 */
final class VmSimpleTest extends TestCase
{
    /**
     * @var Engine\Std
     */
    private $engine;

    /**
     * @var Library
     */
    private $library;
    
    /**
     *
     */
    protected function setUp()
    {
        $directory = TEST_PATH . '/scripts';
        $this->library = new Library\Files($directory);
        $this->engine = new Engine\Vm($this->library);
        $this->engine->helpers()
            ->register('date', new Helper\Callback(function ($args) {
                return date($args->at(1));
            }))
            ->register('echo', new Helper\Callback(function ($args) {
                return $args->at(1);
            }))
            ->register('first', new Helper\Callback(function ($args) {
                return $args->at(1);
            }))
            ->register('typeof', new Helper\Callback(function ($args) {
                $v = $args->at(1);
                return is_object($v) ? get_class($v) : gettype($v);
            }))
            ->register('join', new Helper\Callback(function ($args) {
                $glue = $args->option('glue') ?: ' ';
                $parts = $args->vector();
                array_shift($parts);                
                return implode($glue, $parts);
            }))
        ;
    }


    public function testExecError()
    {
        $this->expectException(Exception::class);
        $engine = new Engine\Vm();
        $script = new Script\Memory('{{#no-helper 123}}');
        $engine->template($script);
    }

    
}
