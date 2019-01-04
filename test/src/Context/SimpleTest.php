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
final class SimpleTest extends BaseTestCase
{

    public function test1()
    {
        $model = [
            'aa' => 11,
            'bb' => [
                'xx' => 77,
                'cc' => 88,
            ],
            'cc' => 00
        ];
        $context = new Context\Simple($model);
        $this->assertEquals(77, $context->node(['bb', 'xx'])->data());
        $this->assertNull($context->node(['bb', 'yy'])->data());
    }

}
