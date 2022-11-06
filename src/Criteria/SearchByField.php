<?php

namespace Bws\Core\Criteria;

use Illuminate\Database\Eloquent\Builder;

class SearchByField implements Criterion
{
    protected $search;

    public function __construct($search = [])
    {
        $this->search = $search;
    }

    public function apply($model)
    {
        $search = $this->search;
        return $model->where(function ($query) use ($model, $search) {
            foreach ($search as $fieldName => $searchValue) {
                $query->where($fieldName, 'LIKE', $searchValue . "%");
            }
        });
    }
}
