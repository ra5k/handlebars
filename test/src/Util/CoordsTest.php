<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ra5k\Handlebars\Test\Util;

// [imports]
use Ra5k\Handlebars\Test\BaseTestCase;
use Ra5k\Handlebars\Util;


/**
 *
 *
 *
 */
final class CoordsTest extends BaseTestCase
{

    public function test1()
    {
        $s = "ABCD\nEFGH\nIJKL";
        $c = new Util\Coords($s, strpos($s, 'A'));       
        $this->assertEquals(1, $c->line());
        $this->assertEquals(1, $c->column());
    }

    public function test2()
    {
        $s = "ABCD\nEFGH\nIJKL";
        $c = new Util\Coords($s, strpos($s, 'L'));        
        $this->assertEquals(3, $c->line());
        $this->assertEquals(4, $c->column());
    }

    public function test3()
    {
        $s = "ABCD\nEFGH\nIJKL";
        $c = new Util\Coords($s, strpos($s, 'G'));        
        $this->assertEquals(2, $c->line());
        $this->assertEquals(3, $c->column());
    }

    public function test4()
    {
        $s = "";
        $c = new Util\Coords($s, 0);
        $this->assertEquals(1, $c->line());
        $this->assertEquals(1, $c->column());
    }
    
    public function test5()
    {
        $s = "ABCDEFGHIJKL";
        $c = new Util\Coords($s, strpos($s, 'G'));
        $this->assertEquals(1, $c->line());
        $this->assertEquals(7, $c->column());
    }
    
}
