<?php

namespace Bws\Core\Classes\Form\Concerns;

trait IsFocus
{
    protected $focus = false;

    public function isFocus(): bool
    {
        return $this->focus;
    }

    public function focus()
    {
        $this->focus = true;
        return $this;
    }
}
