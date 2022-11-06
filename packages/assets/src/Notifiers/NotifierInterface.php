<?php

namespace Bws\Assets\Notifiers;

interface NotifierInterface
{
    /**
     * Allow the object to be serialized in laravel's config cache
     *
     * @return static
     */
    public static function __set_state(array $properties);

    /**
     * This function is called whenever an asset file is created.
     *
     * If your 'destination_url' does not correspond to the
     * 'destination' folder, (e.g. Amazon S3, etc), then you
     * can use this opportunity to copy it.
     *
     * @param string $asset The filename of the asset.
     */
    public function created($asset);
}
