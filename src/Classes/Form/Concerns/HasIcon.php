<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasIcon
{
    protected $icon;

    public function getIcon()
    {
        return $this->icon;
    }

    public function icon($icon)
    {
        $this->icon = $icon;
        return $this;
    }
}
