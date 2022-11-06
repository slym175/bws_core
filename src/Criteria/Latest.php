<?php

namespace Bws\Core\Criteria;

use Illuminate\Database\Eloquent\Builder;

class Latest implements Criterion
{
    protected $column;

    public function __construct($column = 'id')
    {
        $this->column = $column;
    }

    public function apply($model)
    {
        return $model->orderByDesc($this->column);
    }
}
