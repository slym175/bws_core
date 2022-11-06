<?php

if (!function_exists('dashboard_menu')) {
    function dashboard_menu()
    {
        return app('dashboard_menu');
    }
}

if (!function_exists('get_dashboard_menu')) {
    function get_dashboard_menu()
    {
        return dashboard_menu()->getAll();
    }
}

if (!function_exists('add_dashboard_menu_item')) {
    function add_dashboard_menu_item($options)
    {
        return dashboard_menu()->addMenuItem($options);
    }
}
