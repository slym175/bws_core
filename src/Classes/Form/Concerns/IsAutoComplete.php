<?php

namespace Bws\Core\Classes\Form\Concerns;

trait IsAutoComplete
{
    protected $autoComplete = false;

    public function isAutoComplete(): bool
    {
        return $this->autoComplete;
    }

    public function autoComplete()
    {
        $this->autoComplete = true;
        return $this;
    }
}
