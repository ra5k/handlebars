<?php
/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars;


/**
 *
 *
 */
interface Script
{
    /**
     * The unique ID of the script within its library
     * @reutrn string
     */
    public function id(): string;

    /**
     * The script name (path)
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function content(): string;

    /**
     * Indicates whether this is a valid script
     * @return bool
     */
    public function exists(): bool;
    
}
