<?php

namespace Bws\Assets\Loaders;

interface LoaderInterface
{
    /**
     * Allow the object to be serialized in laravel's config cache
     *
     * @return static
     */
    public static function __set_state(array $properties);

    /**
     * @param string $asset_url Load an asset from this URL.
     *
     * @return string
     */
    public function loadUrl($asset_url);
}
