<?php

namespace Bws\Core\Criteria;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

class EagerLoad implements Criterion
{
    protected $relations;

    public function __construct(...$relations)
    {
        $this->relations = Arr::flatten($relations);
    }

    public function apply($model)
    {
        return $model->with($this->relations);
    }
}
