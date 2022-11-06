<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasOptions
{
    protected $options = [];

    public function getOptions()
    {
        return $this->options;
    }

    public function options(array|Closure|callable $options = [])
    {
        if(is_callable($options)) $options = $options();
        $this->options = $options;
        return $this;
    }
}
