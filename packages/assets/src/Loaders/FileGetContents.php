<?php

namespace Bws\Assets\Loaders;

use Bws\Assets\SetStateTrait;

class FileGetContents implements LoaderInterface
{
    use SetStateTrait;

    /**
     * Load external assets using PHP's built-in function.
     *
     * @param string $asset_url Load an asset from this URL.
     *
     * @return string
     */
    public function loadUrl($asset_url)
    {
        return file_get_contents($asset_url);
    }
}
