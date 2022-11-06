<?php

namespace Bws\Core\Http\Repositories\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property-read Builder|Model $model
 * @mixin \Bws\Core\Http\Repositories\EloquentRepository
 */
trait CreatesEntity
{
    /**
     * Creates model.
     *
     * @param mixed $properties
     *
     * @return Builder|Model
     */
    public function create($properties)
    {
        return $this->model->create($properties);
    }
}
