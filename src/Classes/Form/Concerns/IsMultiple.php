<?php

namespace Bws\Core\Classes\Form\Concerns;

trait IsMultiple
{
    protected $multiple = false;

    public function isMultiple()
    {
        return $this->multiple;
    }

    public function multiple()
    {
        $this->multiple = true;
        return $this;
    }

}
