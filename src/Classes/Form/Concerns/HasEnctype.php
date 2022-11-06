<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasEnctype
{
    protected $enctype = 'multipart/form-data';

    public function getEnctype(): string
    {
        return $this->enctype;
    }

    public function enctype(string|Closure|callable $enctype = 'multipart/form-data')
    {
        if(is_callable($enctype)) $enctype = $enctype();

        $this->enctype = $enctype;
        return $this;
    }
}
