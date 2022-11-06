<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasPlaceholder
{
    protected $placeholder = '';

    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    public function placeholder(string|Closure|callable $placeholder)
    {
        if(is_callable($placeholder)) $placeholder = $placeholder();

        $this->placeholder = $placeholder;
        return $this;
    }
}
