<?php

namespace Bws\Core\Criteria;

use Illuminate\Database\Eloquent\Builder;

class OrderBy implements Criterion
{
    protected $column;
    protected $sortBy;

    public function __construct($column = '', $sortBy = 'ASC')
    {
        $this->column = $column;
        $this->sortBy = $sortBy;
    }

    public function apply($model)
    {
        $column = $this->column ? $this->column : $model->getKeyName();
        return $model->orderBy($column, $this->sortBy);
    }
}
