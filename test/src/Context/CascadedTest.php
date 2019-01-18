<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Ra5k\Handlebars\Test\Context;

// [imports]
use Ra5k\Handlebars\Test\BaseTestCase;
use Ra5k\Handlebars\Context;


/**
 *
 *
 *
 */
final class CascadedTest extends BaseTestCase
{

    public function test1()
    {
        $root = new Context\Cascaded([
            'aa' => 11,
            'bb' => [
                'xx' => 77,
                'yy' => 88,
            ],
            'cc' => 22,
            'yy' => 33,
        ]);
        
        $bb = $root->node(['bb']);
        $xx = $bb->node(['xx']);
        $yy = $bb->node(['yy']);
        $cc = $bb->node(['cc']);
        $nn = $bb->node(['nn']);

        $this->assertEquals(77, $xx->data());
        $this->assertEquals(22, $cc->data());
        $this->assertEquals(88, $yy->data());
        $this->assertNull($nn->data());
    }

}
