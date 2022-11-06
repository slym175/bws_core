<?php

namespace Bws\Core\Http\Repositories\Concerns;

use Bws\Core\Http\Repositories\Interfaces\CacheableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method Builder|Model find($modelId)
 * @method void invalidateCache($model)
 * @mixin \Bws\Core\Http\Repositories\EloquentRepository
 */
trait UpdatesEntity
{
    /**
     * Finds a model with ID and updates it with given properties.
     *
     * @param int|string $modelId
     * @param mixed $properties
     *
     * @return Builder|Model
     */
    public function findAndUpdate($modelId, $properties)
    {
        $model = $this->find($modelId);

        return $this->update($model, $properties);
    }

    /**
     * Updates a model given properties.
     *
     * @param Model $model
     * @param mixed $properties
     *
     * @return Builder|Model
     */
    public function update($model, $properties)
    {
        if ($this instanceof CacheableInterface) {
            $this->invalidateCache($model);
        }

        $model->fill($properties)->save();

        return $model->refresh();
    }
}
