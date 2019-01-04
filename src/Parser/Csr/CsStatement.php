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
 * Analyze a Handlebars statement
 *
 * Statement ::= "{{" Path ( Path | Primitive | Option | "(" SubStatement ")" )* "}}"
 * Option    ::= Name "=" Path
 *
 */
final class CsStatement
{
    // [traits]
    use CsCommon, CsTag;

    /**
     * @var bool
     */
    private $sub;
    
    /**
     * @param bool $sub
     */
    public function __construct(bool $sub = false)
    {
        $this->sub = $sub;
    }   
    
    /**
     *
     * @param Token $start
     * @param Token $head
     * @return Packet
     */
    public function parse(Token $start): Packet
    {
        $open = $start->content();
        $first = $this->eatSpace($start->next());
        $path = (new CsPath)->parse($first);
        $args = (new CsArguments($this->sub))->parse($path->next());
        $after = $args->next();
        $node = $this->normalizeTag([
            'type' => 'stmt',
            'offset' => $start->offset(),
            'length' => $after->offset() - $start->offset(),
            'escape' => ($open != '{{{' && $open != '{{&'),
            'stmt' => $path->model(),
            'arguments' => $args->model(),
        ]);
        return new Packet($node, $after);
    }
    
}
