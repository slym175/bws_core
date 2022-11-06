<?php

namespace Bws\Core\Http\Repositories\Interfaces;

interface CacheableInterface
{
    /**
     * Defines cache key.
     *
     * @return string
     */
    public function cacheKey(): string;

    /**
     * Removes cache for model.
     *
     * @param $model
     */
    public function invalidateCache($model): void;
}
