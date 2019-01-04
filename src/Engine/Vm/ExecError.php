<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Engine\Vm;


// [imports]
use Ra5k\Handlebars\{Exception, Ast\Node};
use Ra5k\Handlebars\Util\Coords;
use RuntimeException, Throwable;


/**
 *
 *
 *
 */
final class ExecError extends RuntimeException implements Exception
{
    /**
     * @var Coords
     */
    private $coords;

    /**
     *
     * @param Node $node
     * @param string $details
     * @param Throwable $previous
     */
    public function __construct(Node $node, string $source, string $details = "", int $code = 0, Throwable $previous = null)
    {
        $coords = $c = new Coords($source, $node->prop('offset'));
        $message = sprintf("Execution error on line %d, column %d", $coords->line(), $coords->column());
        if ($details) {
            $message .= ": " . $details;
        }
        parent::__construct($message, $code, $previous);
        $this->coords = $coords;
    }

    /**
     * @return Coords
     */
    public function coords(): Coords
    {
        return $this->coords;
    }

}
