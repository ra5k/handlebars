<?php
/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Context;


// [imports]
use Ra5k\Handlebars\Context;


/**
 *
 *
 *
 */
final class Cascaded implements Context
{
    // [traits]
    use Extract;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var Context
     */
    private $parent;

    /**
     * @param mixed $data
     */
    public function __construct($data, Context $parent = null)
    {
        $this->data = ($data instanceof Context) ? $data->data() : $data;
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return true;
    }

    /**
     * @return Context
     */
    public function parent(): Context
    {
        return $this->parent ?: new Dummy();
    }

    /**
     * @param mixed $data
     * @return Context
     */
    public function child($data): Context
    {
        return new self($data, $this);
    }

    /**
     *
     * @param array $path
     * @return Context
     */
    public function node(array $path): Context
    {        
        $node = $this;        
        while ($node->exists()) {
            $found = true;
            $data = $node->data();
            foreach ($path as $k) {
                if (!$this->extract($k, $data, $data)) {
                    $found = false;
                    break;
                }
            }
            if ($found) {
                break;
            }
            $node = $node->parent();
        }
        
        return ($found) ? new self($data, $this) : new Dummy;
    }

}
