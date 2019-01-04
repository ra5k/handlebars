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
final class Overlay implements Context
{
    /**
     * @var Context
     */
    private $base;

    /**
     * @var Context
     */
    private $overlay;

    /**
     * @param Context $base
     * @param Context $overlay
     */
    public function __construct(Context $base, Context $overlay)
    {
        $this->base = $base;
        $this->overlay = $overlay;
    }

    public function data()
    {
        return $this->overlay->exists() ? $this->overlay->data() : $this->base->data();
    }

    public function exists(): bool
    {
        return $this->overlay->exists() || $this->base->exists();
    }

    public function child($data): Context
    {
        $child = $this->overlay->child($data);
        return $child->exists() ? $child : $this->base->child($child);
    }

    public function node(array $path): Context
    {
        if ($path) {
            $node = $this->overlay->node($path);
            $result = $node->exists() ? $node : $this->base->node($path);            
        } else {
            $result = $this->base->node($path);
        }
        return $result;
    }

    public function parent(): Context
    {
        return $this->overlay->exists() ? $this->overlay->parent() : $this->base->parent();
    }

}
