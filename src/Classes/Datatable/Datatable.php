<?php

namespace Bws\Core\Classes\Datatable;

use Illuminate\Contracts\Support\Renderable;

class Datatable implements Renderable
{
    protected $data;
    protected $columns = [];
    protected $actions = [];
    protected $filters = [];

    public function make($data)
    {
        $this->data = $data;
        return $this;
    }

    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
        return $this;
    }

    public function addActions($actions = [])
    {
        $this->actions = $actions;
        return $this;
    }

    public function render()
    {
        $objectVars = get_object_vars($this);
        return view('bws@core::utilities.crud.page.list', $objectVars);
    }
}
