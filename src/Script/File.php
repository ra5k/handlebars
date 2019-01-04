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
use Ra5k\Handlebars\{Script, Library, Location};


/**
 *
 *
 *
 */
final class File implements Script
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $source;

    /**
     * The absolute file name
     * @var string
     */
    private $path;

    /**
     * @var Library\Files
     */
    private $library;

    /**
     * @param Library\Files $library
     */
    public function __construct(Library\Files $library, Location $location)
    {
        $this->library = $library;
        $this->name = $location->str();
        $root = new Location\Str("/");
        $base = $library->directory();
        $path = $base->resolve($root->relativize($location))->str() . $library->suffix();
        $this->path = $path;
    }

    /**
     *
     * @return string
     */
    public function id(): string
    {
        $stat = stat($this->path);
        $dev = $stat['dev'];
        $ino = $stat['ino'] ?: sha1($this->path);
        return "{$dev}_{$ino}";
    }

    /**
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     *
     * @return string
     */
    public function content(): string
    {
        if ($this->source === null) {
            $this->source = (string) file_get_contents($this->path);
        }
        return $this->source;
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->path);
    }

}
