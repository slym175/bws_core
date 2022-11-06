<?php

namespace Bws\Core\Criteria;

interface Criterion
{
    /**
     * @param mixed $model
     *
     * @return mixed
     */
    public function apply($model);
}
