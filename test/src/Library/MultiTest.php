<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ra5k\Handlebars\Test\Library;

// [imports]
use PHPUnit\Framework\TestCase;
use Ra5k\Handlebars\{Library};


/**
 *
 *
 *
 */
final class MultiTest extends TestCase
{

    /**
     * @var Library\Multi
     */
    private $lib;

    /**
     *
     */
    public function setUp()
    {
        $this->lib = new Library\Multi();
        $this->lib
            ->add("m/", new Library\Files(SCRIPT_PATH . '/multi1'))
            ->add("m/", new Library\Files(SCRIPT_PATH . '/multi2'))
        ;
    }

    public function test1()
    {
        $s = $this->lib->script("m/a");
        $this->assertEquals($this->contents("multi2/a"), $s->content());
    }

    public function test2()
    {
        $s = $this->lib->script("m/b");
        $this->assertEquals($this->contents("multi1/b"), $s->content());
    }

    public function test3()
    {
        $s = $this->lib->script("m/c");
        $this->assertEquals($this->contents("multi2/c"), $s->content());
    }

    public function test4()
    {
        $s = $this->lib->script("m");
        $this->assertFalse($s->exists());
    }

    public function test5()
    {
        $s = $this->lib->script("x");
        $this->assertFalse($s->exists());
    }

    private function contents($path)
    {
        return file_get_contents(SCRIPT_PATH . "/$path.hbs");
    }

}
