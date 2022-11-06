<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasLabel
{
    protected $label = '';

    public function getLabel()
    {
        return $this->label;
    }

    public function label(string|Closure|callable $label)
    {
        if(is_callable($label)) $label = $label();
        $this->label = $label;
        return $this;
    }
}
