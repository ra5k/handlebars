<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Parser\Csr;

// [imports]
// use Ra5k\Handlebars\Ast\Node;

/**
 * Helper class
 *
 * @internal
 */
final class Packet
{
    /**
     * @var mixed
     */
    private $model;

    /**
     * @var Token
     */
    private $next;

    /**
     * @param mixed $model
     * @param Token $next
     */
    public function __construct($model, Token $next)
    {
        $this->model = $model;
        $this->next = $next;
    }

    /**
     * @return mixed
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return Token
     */
    public function next(): Token
    {
        return $this->next;
    }

}
