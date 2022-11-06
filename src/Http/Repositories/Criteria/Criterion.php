<?php

namespace Bws\Core\Http\Repositories\Criteria;

interface Criterion
{
    /**
     * @param mixed $model
     *
     * @return mixed
     */
    public function apply($model);
}
