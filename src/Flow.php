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
 * TODO: Add a source byte offset to make error handling more informative. This might not be
 *       possible in the PC engine without additional information.
 *
 */
interface Flow
{
    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * The flow parameters
     * @return array
     */
    public function params(): array;

    /**
     * @param Context $context
     * @return mixed
     */
    public function exec(Context $context);

    /**
     * @param Context $context
     */
    public function alt(Context $context);

    /**
     * @param string $name
     * @param array $params
     * @return self
     */
    public function load(string $name): self;

    /**
     * @param array $params
     * @return self
     */
    public function withParams(array $params): self;

}
