<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Ast\Node;

// [imports]
use Ra5k\Handlebars\Ast\Node;
use Iterator;


/**
 *
 *
 *
 */
final class Arr implements Node
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        $data = $this->data;
        $type = $data['type'] ?? (is_null($data) || is_scalar($data) ? gettype($data) : '');
        return (string) $type;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function prop(string $name, $default = null)
    {
        return $this->data[$name] ?? $default;
    }

    /**
     *
     * @return Iterator
     */
    public function elements(): Iterator
    {
        if (isset($this->data['elements'])) {
            $children = (array) $this->data['elements'];
            foreach ($children as $c) {
                yield new self($c);
            }
        }
    }

    /**
     *
     * @return Iterator
     */
    public function alternatives(): Iterator
    {
        if (isset($this->data['alternatives'])) {
            $children = (array) $this->data['alternatives'];
            foreach ($children as $c) {
                yield new self($c);
            }
        }
    }

    /**
     *
     * @return array
     */
    public function export(): array
    {
        return $this->data;
    }

}
