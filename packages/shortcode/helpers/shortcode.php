<?php

if (!function_exists('shortcode')) {
    function shortcode()
    {
        return app('shortcode');
    }
}

if (!function_exists('add_shortcode')) {
    function add_shortcode($shortcode, $display_name, $group, $callback, $params = [])
    {
        return app('shortcode')->register($shortcode, $display_name, $group, $callback, $params);
    }
}

if (!function_exists('do_shortcode')) {
    function do_shortcode($content)
    {
        return app('shortcode')->compile($content);
    }
}
// Demo shortcode
add_shortcode('something', 'Something', 'hello', function ($atts, $content, $view_data) {
    return 'something_shortcode';
}, [
    'name' => [
        'type' => 'text',
        'value' => '',
        'label' => 'Name'
    ],
    'option' => [
        'type' => 'single_select',
        'value' => '',
        'label' => 'Option',
        'options' => ['Option 1', 'Option 2']
    ],
    'options' => [
        'type' => 'multiple_select',
        'value' => [],
        'label' => 'Options',
        'options' => ['Option 1', 'Option 2', 'Option 3']
    ]
]);

