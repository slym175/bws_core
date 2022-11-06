<?php

namespace Bws\Core\Http\Repositories\Concerns;

use Bws\Core\Http\Repositories\Interfaces\CacheableInterface;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property-read Builder|Model $model
 * @property-read Factory $cache
 * @method string cacheKey()
 * @method int cacheTTLValue()
 * @mixin \Bws\Core\Http\Repositories\EloquentRepository
 */
trait SelectsEntity
{
    /**
     * Returns all models.
     *
     * @return Builder[]|Collection
     */
    public function all()
    {
        if ($this instanceof CacheableInterface) {
            return $this->cache->remember(
                $this->cacheKey() . '.*',
                $this->cacheTTLValue(),
                function () {
                    return $this->model->get();
                }
            );
        }

        return $this->model->get();
    }

    /**
     * Returns all models with selected columns.
     *
     * @param mixed $columns
     *
     * @return Builder[]|Collection
     */
    public function get(...$columns)
    {
        $columns = Arr::flatten($columns);

        if (count($columns) === 0) {
            $columns = ['*'];
        }

        return $this->model->get($columns);
    }

    /**
     * Finds a model with ID.
     *
     * @param int|string $modelId
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($modelId)
    {
        if ($this instanceof CacheableInterface) {
            $model = $this->cache->remember(
                $this->cacheKey() . '.' . $modelId,
                $this->cacheTTLValue(),
                function () use ($modelId) {
                    return $this->model->find($modelId);
                }
            );
        } else {
            $model = $this->model->find($modelId);
        }

        if (! $model) {
            $this->throwModelNotFoundException($modelId);
        }

        return $model;
    }

    /**
     * Finds a model with ID.
     *
     * @param int|string $modelId
     *
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findOrFail($modelId)
    {
        if ($this instanceof CacheableInterface) {
            $model = $this->cache->remember(
                $this->cacheKey() . '.' . $modelId,
                $this->cacheTTLValue(),
                function () use ($modelId) {
                    return $this->model->findOrFail($modelId);
                }
            );
        } else {
            $model = $this->model->findOrFail($modelId);
        }

        if (! $model) {
            $this->throwModelNotFoundException($modelId);
        }

        return $model;
    }

    /**
     * Paginates models.
     *
     * @param int $perPage
     *
     * @return Builder[]|Collection|mixed
     */
    public function paginate(int $perPage)
    {
        return $this->model->paginate($perPage);
    }

    /**
     * Finds models with "where" condition.
     *
     * @param string|array $column
     * @param mixed $value
     *
     * @return Builder[]|Collection
     */
    public function getWhere($column, $value = null)
    {
        if (is_array($column)) {
            return $this->model->where($column)->get();
        }

        return $this->model->where($column, $value)->get();
    }

    /**
     * Finds models with "whereIn" condition.
     *
     * @param string $column
     * @param mixed $values
     *
     * @return Builder[]|Collection
     */
    public function getWhereIn(string $column, $values)
    {
        return $this->model->whereIn($column, $values)->get();
    }

    /**
     * Finds first model with "where" condition.
     *
     * @param string|array $column
     * @param mixed $value
     *
     * @return Builder|Model|object|null
     */
    public function getWhereFirst($column, $value = null)
    {
        if (is_array($column)) {
            $model = $this->model->where($column)->first();
        } else {
            $model = $this->model->where($column, $value)->first();
        }

        if (! $model) {
            $this->throwModelNotFoundException();
        }

        return $model;
    }

    /**
     * Finds first model with "whereIn" condition.
     *
     * @param string $column
     * @param mixed $values
     *
     * @return Builder|Model|object|null
     */
    public function getWhereInFirst(string $column, $values)
    {
        $model = $this->model->whereIn($column, $values)->first();

        if (! $model) {
            $this->throwModelNotFoundException();
        }

        return $model;
    }
}
