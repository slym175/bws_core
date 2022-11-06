<?php

namespace Bws\Core\Contracts;

use Illuminate\Contracts\Support\Renderable;

interface DatatableInterface extends Renderable
{
    public function make($data);
    public function addColumns($columns = []);
    public function addActions($actions = []);
    public function render();
}
