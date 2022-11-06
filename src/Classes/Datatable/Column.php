<?php

namespace Bws\Core\Classes\Datatable;

class Column
{
    protected $name;
    protected $label;
    protected $callback = null;

    public function make($name, $label, $callback)
    {
        $this->name = $name;
        $this->label = $label;
        if(is_callable($callback)) {
            $this->callback = $callback;
        }
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getCallback()
    {
        return $this->callback;
    }
}
