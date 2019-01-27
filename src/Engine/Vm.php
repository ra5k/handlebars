<?php

/*
 * This file is part of the Ra5k Handlebars implementation
 * (c) 2019 Ra5k <ra5k@mailbox.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ra5k\Handlebars\Engine;

// [imports]
use Ra5k\Handlebars\{Engine, Ast, Template, Helper, Parser, Library, Script, Format};

/**
 * The Virtual Machine compiler
 *
 *
 */
final class Vm implements Engine
{
    /**
     * @var Library
     */
    private $library;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @var Helper\Store
     */
    private $helpers;

    /**
     * @var Format
     */
    private $format;
    
    /**
     * @param Library $library
     * @param Format $escape
     * @param Helper\Store $helpers
     * @param Parser $parser
     */
    public function __construct(Library $library = null, Format $escape = null, Helper\Store $helpers = null, Parser $parser = null)
    {
        $this->library = $library ?? new Library\Dummy;
        $this->format = $escape ?? new Format\Html();
        $this->parser = $parser ?? new Parser\Once(new Parser\Csr);
        $this->helpers = $helpers ?? new Helper\Store\Std();
    }

    /**
     * @param string $path
     * @param Script $referer
     * @return Script
     */
    public function script(string $path, Script $referer = null): Script
    {
        return $this->library->script($path, $referer);
    }

    /**
     * @param Script $script
     * @return Template
     */
    public function template(Script $script): Template
    {
        return $this->translate($this->model($script));
    }

    /**
     * @return Helper\Store
     */
    public function helpers(): Helper\Store
    {
        return $this->helpers;
    }

    /**
     * Returns the output format filter
     * @return Format
     */
    public function format(): Format
    {
        return $this->format;
    }
    
    /**
     * @param Script $script
     * @return Ast
     * 
     * @internal
     */
    public function model(Script $script): Ast
    {
        return $this->parser->model($script);
    }
    
    /**
     * @param Ast $model
     * @param array $params
     * @return Template
     */
    private function translate(Ast $model): Template
    {
        return new Vm\Core($this, $model);
    }
        
}
