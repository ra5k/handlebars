<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Library;


// [imports]
use Ra5k\Handlebars\{Library, Script, Parser, Engine, Location};

/**
 *
 *
 *
 */
final class Files implements Library
{
    /**
     * @var Location
     */
    private $directory;

    /**
     * @var string
     */
    private $suffix = '.hbs';

    /**
     * @var bool
     */
    private $relative;

    /**
     * @param string $directory
     * @param Engine $engine
     * @param Parser $parser
     */
    public function __construct(string $directory, bool $relative = false)
    {
        $this->directory = (new Location\Str($directory))->asDirectory();
        $this->relative = $relative;
    }

    /**
     * @param string $name
     * @return Script
     */
    public function script(string $name, Script $referer = null): Script
    {
        if ($referer && $this->relative) {
            $ref = new Location\Str($referer->name());
            $name = $ref->resolve($name);
        } else {
            $name = new Location\Str($name);
        }
        return new Script\File($this, $name);
    }

    /**
     * @internal
     * @return Location
     */
    public function directory(): Location
    {
        return $this->directory;
    }

    /**
     * @return string
     */
    public function suffix(): string
    {
        return $this->suffix;
    }

}
