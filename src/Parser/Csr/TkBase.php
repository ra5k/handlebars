<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Parser\Csr;


/**
 *
 *
 *
 */
abstract class TkBase implements Token
{
    /**
     * @var string
     */
    protected $source;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @param string $source
     * @param int $offset
     */
    public function __construct(string $source, int $offset)
    {
        $this->source = $source;
        $this->offset = $offset;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function source(): string
    {
        return $this->source;
    }
    
    /**
     * @return int
     */
    public function offset(): int
    {
       return $this->offset; 
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        return [$this->type(), $this->content(), $this->offset()];
    }

}
