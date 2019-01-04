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
use Ra5k\Handlebars\Exception;
use Ra5k\Handlebars\Util\Coords;
use RuntimeException, Throwable;


/**
 *
 *
 *
 */
final class ParseError extends RuntimeException implements Exception
{
    /**
     * @var Coords
     */
    private $coords;

    /**
     * @param string $details
     * @param int $code
     * @param int $line
     * @param int $column
     * @param Throwable $previous
     */
    public function __construct(Token $token, string $details = "", Throwable $previous = null)
    {
        $coords = new Coords($token->source(), $token->offset());
        $message = sprintf("Parse error on line %d, column %d", $coords->line(), $coords->column());
        if ($details) {
            $message .= ": " . $details;
        }
        parent::__construct($message, 1, $previous);
        $this->coords = $coords;
    }

    public function coords(): Coords
    {
        return $this->coords;
    }

}
