<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasActions
{
    protected $actions = [];

    public function getActions()
    {
        return $this->actions;
    }

    public function actions(array $actions)
    {
        $this->actions = $actions;
        return $this;
    }
}
