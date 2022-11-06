<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasID
{
    protected $id = '';

    public function getId(): string
    {
        return $this->id;
    }

    public function id(string|Closure|callable $id)
    {
        if(is_callable($id)) $id = $id();

        $this->id = $id;
        return $this;
    }
}
