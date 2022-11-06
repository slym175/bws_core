<?php

namespace Bws\Assets\Filters;

use Bws\Assets\Assets;
use Bws\Assets\SetStateTrait;

class RewriteCssUrls implements FilterInterface
{
    use SetStateTrait;

    /**
     * Rewrite relative URLs in CSS files to take account of their new location.
     *
     * CSS files may contain relative URLs, such as "background-image: url(img.jpg)".
     * If our processed CSS file is in a different location, such as "min" instead of
     * "css", then we must rewrite this to "background-image: url(../css/img.jpg)".
     *
     * @param string $data      The data to be filtered
     * @param string $asset_url The original URL for this data
     * @param Assets $assets    The asset manager object, for access to its config settings and utilities
     *
     * @return string
     */
    public function filter($data, $asset_url, $assets)
    {
        if ($assets->isAbsoluteUrl($asset_url)) {
            $prefix = dirname($asset_url);
        } else {
            $destination = $assets->getCssSource() . '/' . dirname($asset_url);
            $prefix      = $assets->relativePath($assets->getDestination(), $destination);
        }

        $data = preg_replace_callback([
            '/(\burl\s*\(\s*")([^"]+?)("\s*\))/',
            '/(\burl\s*\(\s*\')([^\']+?)(\'\s*\))/',
            '/(\burl\s*\(\s*)([^\'"]+?)(\s*\))/',
        ], function ($matches) use ($assets, $prefix) {
            if ($assets->isAbsoluteUrl($matches[2])) {
                return $matches[0];
            } else {
                return $matches[1] . $assets->normalizePath($prefix . '/' . $matches[2]) . $matches[3];
            }
        }, $data);

        return $data;
    }
}
