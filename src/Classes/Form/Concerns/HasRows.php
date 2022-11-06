<?php

namespace Bws\Core\Classes\Form\Concerns;

trait HasRows
{
    protected $rows = 3;

    public function getRows()
    {
        return $this->rows;
    }

    public function rows(int $rows = 3)
    {
        $this->rows = (int)$rows;
        return $this;
    }


}
