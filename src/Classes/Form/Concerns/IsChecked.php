<?php

namespace Bws\Core\Classes\Form\Concerns;

trait IsChecked
{
    protected $checked = false;

    public function isChecked()
    {
        return $this->checked;
    }

    public function checked(bool|Closure|callable $checked = false)
    {
        if(is_callable($checked)) $checked = $checked();
        $this->checked = $checked;
        return $this;
    }
}
