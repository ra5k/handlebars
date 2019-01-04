<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Engine\Vm;

// [imports}
use Ra5k\Handlebars\{Context, Ast\Node, Flow};

/**
 *
 *
 *
 */
final class Cursor implements Flow
{
    /**
     * @var Node
     */
    private $node;

    /**
     * @var array
     */
    private $params;

    /**
     * @var Core
     */
    private $core;

    /**
     * @param Core $core
     * @param Node $node
     * @param array $params
     */
    public function __construct(Core $core, Node $node, array $params)
    {
        $this->core = $core;
        $this->node = $node;
        $this->params = $params;
    }


    /**
     * @param Context $context
     * @return mixed
     */
    public function exec(Context $context)
    {
        $result = null;
        foreach ($this->node->elements() as $child) {
            $cursor = new self($this->core, $child, $this->params);
            $result = $this->core->exec($cursor, $context);
        }
        return $result;
    }

    /**
     *
     * @param Context $context
     * @return mixed
     */
    public function alt(Context $context)
    {
        $result = null;
        foreach ($this->node->alternatives() as $child) {
            $cursor = new self($this->core, $child, $this->params);
            $result = $this->core->exec($cursor, $context);
        }
        return $result;
    }

    /**
     * @param string $name
     * @return Flow
     */
    public function load(string $name): Flow
    {
        $program = $this->core->load($name, $this->params());
        $origin = $program->root();
        $cursor = new self($program, $origin->node(), $origin->params());
        return $cursor;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function params(): array
    {
        return $this->params;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Flow
     */
    public function withParams(array $params): Flow
    {
        return new self($this->core, $this->node, array_merge($this->params, $params));
    }

    /**
     * @return Node
     * @internal
     */
    public function node(): Node
    {
        return $this->node;
    }

}
