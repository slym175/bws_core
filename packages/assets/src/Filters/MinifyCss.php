<?php

namespace Bws\Assets\Filters;

use Bws\Assets\Assets;
use Bws\Assets\SetStateTrait;
use tubalmartin\CssMin\Minifier;

class MinifyCss implements FilterInterface
{
    use SetStateTrait;

    /**
     * Reduce the size of CSS files, using mrclay/minify compressor.
     *
     * @param string $data      The data to be filtered
     * @param string $asset_url The original URL for this data
     * @param Assets $assets    The asset manager object, for access to its config settings and utilities
     *
     * @return string
     */
    public function filter($data, $asset_url, $assets)
    {
        if (!preg_match(Assets::REGEX_MINIFIED_CSS, $asset_url)) {
            $data = (new Minifier())->run($data);
        }

        return $data;
    }
}
