<?php
if (!function_exists('admin_page')) {
    function admin_page() {
        return app('admin_page');
    }
}

if(!function_exists('get_dashboard_prefix')) {
    function get_dashboard_prefix() {
        return config('bws/core.dashboard.prefix', 'admin');
    }
}

if(!function_exists('can_create_account')) {
    function can_create_account() {
        return config('bws/core.can_create_account', false);
    }
}

if(!function_exists('get_dashboard_action')) {
    function get_dashboard_action() {
        return config('bws/core.dashboard.action', \Bws\Core\Http\Controllers\AdminDashboardController::class);
    }
}
