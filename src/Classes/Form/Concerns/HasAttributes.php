<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasAttributes
{
    protected $attributes = [];

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function attributes(array|Closure|callable $attributes = [])
    {
        if(is_callable($attributes)) {
            $attributes = $attributes();
        }

        $this->attributes = $attributes;
        return $this;
    }
}
