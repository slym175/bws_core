<?php

namespace Bws\Core\Criteria;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Builder;

class Scope implements Criterion
{
    protected $scopes;

    public function __construct(...$scopes)
    {
        $this->scopes = Arr::flatten($scopes);
    }

    public function apply($model)
    {
        foreach ($this->scopes as $scope) {
            $model = $model->{$scope}();
        }

        return $model;
    }
}
