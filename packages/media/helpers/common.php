<?php

if (!function_exists('packages_path')) {
    function packages_path($path = null): string
    {
        return base_path('bws/' . $path);
    }
}

if (!function_exists('package_path')) {
    function package_path($path = null): string
    {
        return packages_path('packages/' . $path);
    }
}

if(!function_exists('bws_media')) {
    function bws_media() {
        return app('bws_media');
    }
}

if(!function_exists('bws_helper')) {
    function bws_helper() {
        return app('bws_helper');
    }
}
