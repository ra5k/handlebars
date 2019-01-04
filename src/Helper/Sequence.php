<?php
/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Helper;

// [imports]
use Traversable, Iterator, IteratorAggregate, ArrayIterator, EmptyIterator;

/**
 *
 *
 *
 */
final class Sequence implements IteratorAggregate
{
    /**
     * @var mixed
     */
    private $data;

    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return Traversable
     */
    public function getIterator(): Traversable
    {
        $core = $this->data;
        if (is_array($core)) {
            $items = new ArrayIterator($core);
        } else if ($core instanceof Iterator) {
            $items = $core;
        } else if ($core instanceof IteratorAggregate) {
            $items = $core->getIterator();
        } else if (empty($core)) {
            $items = new EmptyIterator();
        } else {
            $items = new ArrayIterator([$core]);
        }
        return $items;
    }

}
