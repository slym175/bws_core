<?php

if (!function_exists('assets')) {
    function assets()
    {
        return app('assets');
    }
}

if (!function_exists('assets_css')) {
    function assets_css($group = '', array $attributes = [])
    {
        return assets()->css($group, $attributes);
    }
}

if (!function_exists('assets_js')) {
    function assets_js($group = '', array $attributes = [])
    {
        return assets()->css($group, $attributes);
    }
}
