<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasClassName
{
    protected $className = '';

    public function getClassName(): string
    {
        return $this->className;
    }

    public function className(string|Closure|callable $className)
    {
        if(is_callable($className)) $className = $className();

        $this->className = $className;
        return $this;
    }
}
