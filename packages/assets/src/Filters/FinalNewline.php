<?php

namespace Bws\Assets\Filters;

use Bws\Assets\Assets;
use Bws\Assets\SetStateTrait;

class FinalNewline implements FilterInterface
{
    use SetStateTrait;

    /**
     * Force files to have a trailing end-of-line character.
     *
     * "x=3" is valid javascript. "y=4" is valid javascript.  But concatentaing these
     * gives "x=3y=4" which is invalid.  Therefore we must make sure that all JS files
     * end with an end-of-line.
     *
     * @param string $data      The data to be filtered
     * @param string $asset_url The original URL for this data
     * @param Assets $assets    The asset manager object, for access to its config settings and utilities
     *
     * @return string
     */
    public function filter($data, $asset_url, $assets)
    {
        if (substr($data, -1) === "\n") {
            return $data;
        } else {
            return $data . "\n";
        }
    }
}
