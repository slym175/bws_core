<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('router_url')) {
    function router_url($name, $parameters = [], $absolute = true)
    {
        return app('bws_core')->routerUrl($name, $parameters, $absolute);
    }
}

if (!function_exists('ui_avatar')) {
    function ui_avatar($name, $attributes = [], $img = false)
    {
        $defaults = [
            'name' => $name,
            'size' => 64,
            'font_size' => 0.5,
            'length' => 2,
            'rounded' => false,
            'bold' => false,
            'background' => 'random',
            'color' => '8b5d5d',
            'uppercase' => true,
            'format' => 'png'
        ];

        $attributes = array_merge($defaults, $attributes);

        if (!isset($name) && $name) return '';
        $url = 'https://ui-avatars.com/api/?' . http_build_query($attributes);

        if(isset($img) && $img) {
            return '<img src="'.$url.'" alt="'.$name.' Avatar">';
        }

        return $url;
    }
}
