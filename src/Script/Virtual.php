<?php
/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Script;

// [imports]
use Ra5k\Handlebars\{Script};

/**
 *
 *
 *
 */
final class Virtual implements Script
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var bool
     */
    private $exists;

    /**
     * @param string $path
     */
    public function __construct(string $path, bool $exists = false)
    {
        $this->path = $path;
        $this->exists = $exists;
    }

    public function exists(): bool
    {
        return $this->exists;
    }

    public function id(): string
    {
        return 'virtual-' . sha1($this->name());
    }

    public function name(): string
    {
        return $this->path;
    }

    public function content(): string
    {
        return '';
    }

}
