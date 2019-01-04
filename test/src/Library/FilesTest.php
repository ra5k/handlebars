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
use Ra5k\Handlebars\Test\BaseTestCase;
use Ra5k\Handlebars\{Library};


/**
 *
 *
 *
 */
final class FilesTest extends BaseTestCase
{

    public function test1()
    {
        $library = new Library\Files(SCRIPT_PATH);
        $script = $library->script('hello');
        $expected = file_get_contents(SCRIPT_PATH . '/hello.hbs');
        $this->assertEquals($expected, $script->content());
    }

}
