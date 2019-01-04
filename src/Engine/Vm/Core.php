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
use Ra5k\Handlebars\{
    Template,
    Helper,
    Arguments,
    Engine,
    Script,
    Ast,
    Ast\Node,
    Context,
    Text};
use Throwable;


/**
 * The Program logic of the VM compiler
 *
 *
 */
final class Core implements Template
{
    /**
     * @var Engine\Vm
     */
    private $engine;

    /**
     * @var Script
     */
    private $script;

    /**
     * @var Cursor
     */
    private $root;


    /**
     * @param Engine\Vm $engine
     * @param Ast $model
     * @param array $params
     */
    public function __construct(Engine\Vm $engine, Ast $model, array $params = [])
    {
        $this->engine = $engine;
        $this->script = $model->source();
        $this->root = new Cursor($this, $model->root(), $params);
    }

    /**
     * @param Context $context
     * @return void
     */
    public function write($context)
    {
        $data = ($context instanceof Context) ? $context : new Context\Simple($context);
        $this->exec($this->root(), $data);
    }

    /**
     *
     * @param Cursor $cursor
     * @param Context $context
     * @return void
     * 
     * @internal
     */
    public function exec(Cursor $cursor, Context $context)
    {
        $node = $cursor->node();
        switch ($node->type()) {
            case 'text':
                $this->text($cursor);
                break;
            case 'stmt':
                $this->stmt($cursor, $context);
                break;
            case 'block':
                $this->block($cursor, $context);
                break;
            case 'include':
                $this->include($cursor, $context);
                break;
            case 'handlebars':
                $this->program($cursor, $context);
                break;
            case 'comment':
                // ignore;
                break;
            default:
                $msg = sprintf("Node type (%s) not supported", $node->type());
                throw new ExecError($node, $this->script->content(), $msg, 4);
        }
    }

    /**
     * This method loads a partial script
     * 
     * @param string $name
     * @return self
     *
     * @internal
     */
    public function load(string $name, array $params): self
    {
        $engine = $this->engine;
        $script = $engine->script($name, $this->script);
        $model  = $engine->model($script);
        return new self($engine, $model, $params);
    }

    /**
     * @return Cursor
     */
    public function root(): Cursor
    {
        return $this->root;
    }

    /**
     * @return Script
     */
    public function script(): Script
    {
        return $this->script;
    }

    /**
     * @param Cursor $cursor
     * @param Context $context
     */
    private function program(Cursor $cursor, Context $context)
    {
        foreach ($cursor->node()->elements() as $node) {
            $child = new Cursor($this, $node, $cursor->params());
            $this->exec($child, $context);
        }
    }

    /**
     * Renders a text node
     * @param Cursor $cursor
     * 
     * @return void
     */
    private function text(Cursor $cursor)
    {
        $node   = $cursor->node();
        $source = $this->script->content();
        $offset = $node->prop('offset');
        $length = $node->prop('length');
        if ($offset === null) {
            $slice = $source;
        } else {
            if ($length === null) {
                $slice = substr($source, $offset);
            } else {
                $slice = substr($source, $offset, $length);
            }
        }
        echo $slice;
    }

    /**
     * @param Cursor $cursor
     * @param Context $context
     */
    private function stmt(Cursor $cursor, Context $context)
    {
        $result = $this->eval($cursor, $context);
        $this->print($result, $cursor);
    }

    /**
     * Evaluates a statement node
     *
     * @param Cursor $cursor
     * @param Context $context
     * 
     * @return mixed
     */
    private function eval(Cursor $cursor, Context $context)
    {
        $node = $cursor->node();
        $path = $node->prop('stmt');
        $name = (string) $path['name'] ?? '';
        $helper = $this->engine->helpers()->get($name);
        $args = $this->arguments($cursor, $context, 'stmt');
        $result = null;
        //        
        if ($helper->exists()) {
            $result = $this->delegate($helper, $args, $context, $cursor);
        } else {
            $result = $this->resolve($path, $cursor, $context);            
            if ($result instanceof Text) {
                // pass;
            } else if ($node->prop('escape')) {
                $result = new Text\Raw($this->format($result, $node));
            } else {
                $result = new Text\Raw($result);
            }
        }
        return $result;
    }

    /**
     * @param mixed $content
     * @param Cursor $cursor
     */
    private function print($content, Cursor $cursor)
    {
        echo ($content instanceof Text) ? $content->toString() : $this->format($content, $cursor->node());
    }
    
    /**
     * @param string $content
     * @return string
     */
    private function format($content, Node $origin)
    {
        try {
            $format = $this->engine->format();
            $text = $format->text($content);
        } catch (Throwable $ex) {
            throw new ExecError($origin, $this->script->content(), $ex->getMessage(), 2, $ex);
        }
        return $text;
    }
    
    /**
     * Handles a block node
     * @param Cursor $cursor
     * @param Context $context
     * @return void
     */
    private function block(Cursor $cursor, Context $context)
    {
        $node = $cursor->node();
        $path = $node->prop('stmt');
        $name = (string) $path['name'] ?? '';
        $helper = $this->engine->helpers()->get($name);
        $args = $this->arguments($cursor, $context, 'stmt');
        //
        if ($helper->exists()) {
            $result = $this->delegate($helper, $args, $context, $cursor);
            $this->print($result, $cursor);
        } else {
            if (empty($args->vector()) && empty($args->hash())) {
                $args = new Arguments\Unshifted('each', $args);
                $this->section($args, $cursor, $context);
            } else {
                throw new ExecError($node, $this->script->content(), "Helper '$name' not found", 1);
            }
        }
    }

    /**
     * Handles an 'include' node
     * @param Cursor $cursor
     * @param Context $context
     * @return void
     */
    private function include(Cursor $cursor, Context $context)
    {
        $engine = $this->engine;
        $name = (string) $this->primary($cursor, $context, 'include');
        $script = $engine->script($name, $this->script);
        $model  = $engine->model($script);
        $foreign = new self($engine, $model, $cursor->params());
        $args = $this->arguments($cursor, $context, 'include');
        $mask = new Context\Overlay($context, new Context\Simple($args->hash()));
        $foreign->exec($foreign->root(), $mask);
    }

    /**
     * Calls the helper and returns its result
     * 
     * @param Helper $helper
     * @param Arguments $args
     * @param Context $context
     * @param Cursor $cursor
     * 
     * @return mixed
     * @throws ExecError
     */
    private function delegate(Helper $helper, Arguments $args, Context $context, Cursor $cursor)
    {
        try {
            $result = $helper->exec($args, $context, $cursor);
        } catch (ExecError $e) {
            throw $e;
        } catch (Throwable $e) {
            $node = $cursor->node();
            throw new ExecError($node, $this->script->content(), $e->getMessage(), 3, $e);
        }
        return $result;
    }

    /**
     * @param Cursor $cursor
     * @param Context $context
     * @param string $key
     * 
     * @return Arguments
     */
    private function arguments(Cursor $cursor, Context $context, string $key): Arguments
    {
        $node = $cursor->node();
        //
        $arguments = [ $this->primary($cursor, $context, $key) ];
        foreach ((array) $node->prop('arguments') as $arg) {
            $arguments[] = $this->resolve($arg, $cursor, $context);
        }
        //
        $options = [];
        foreach ((array) $node->prop('options') as $name => $value) {
            $options[$name] = $this->resolve($value, $cursor, $context);
        }
        //
        return new Arguments\Arr($arguments, $options);
    }

    /**
     * @param Arguments $arguments
     * @param Cursor $cursor
     * @param Context $context
     * @return void
     */
    private function section(Arguments $arguments, Cursor $cursor, Context $context)
    {
        $sequence = new Sequence($arguments->at(1));
        foreach ($sequence as $key => $value) {
            $sub = $context->child($value);
            $tmp = new Context\Simple(['this' => $value, '@key' => $key]);
            $this->exec($cursor, new Context\Overlay($sub, $tmp));
        }
    }

    /**
     * @param Cursor $cursor
     * @param Context $context
     * @param string $key
     * @return mixed
     */
    private function primary(Cursor $cursor, Context $context, string $key)
    {
        $primary = null;
        $node = $cursor->node();
        $first = $node->prop($key);
        if (is_scalar($first) || is_null($first)) {
            $primary = $first;
        } else if (is_array($first)) {
            $first = new Node\Arr($first);
            $type = $first->type();
            if ($type == 'path') {
                $primary = $first->prop('name');
            } else if ($type == 'stmt') {
                $primary = $this->stmt($first, $context);
            }
        }
        return $primary;
    }

    /**
     * Resolves an element of the syntax tree within the given $context
     * 
     * @param mixed $element
     * @param Cursor $cursor
     * @param Context $context
     * 
     * @return mixed
     */
    private function resolve($element, Cursor $cursor, Context $context)
    {
        $value = null;
        if (is_scalar($element) || is_null($element)) {
            $value = $element;
        } else if (is_array($element)) {
            $node = new Node\Arr($element);
            $type = $node->type();
            if ($type == 'path') {
                $path = (array) $node->prop('path');
                $value = $context->node($path)->data();
            } else if ($type == 'stmt') {
                $child = new Cursor($this, $node, $cursor->params());
                $value = $this->eval($child, $context);
            } else {
                throw new InternalError("Node type ($type) cannot be resolved");
            }
        } else {
            $type = is_object($element) ? get_class($element) : gettype($element);
            throw new InternalError("Element type ($type) cannot be resolved");
        }
        return $value;
    }

}
