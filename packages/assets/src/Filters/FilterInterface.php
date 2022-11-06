<?php

namespace Bws\Assets\Filters;

use Bws\Assets\Assets;

interface FilterInterface
{
    /**
     * Allow the object to be serialized in laravel's config cache
     *
     * @return static
     */
    public static function __set_state(array $properties);

    /**
     * @param string $data      The data to be filtered
     * @param string $asset_url The original URL for this data
     * @param Assets $assets    The asset manager object, for access to its config settings and utilities
     *
     * @return string
     */
    public function filter($data, $asset_url, $assets);
}
