<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasValue
{
    protected $value = null;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue(array|string|Closure|callable $value)
    {
        if(is_callable($value)) $value = $value();
        $this->value = $value;
        return $this;
    }
}
