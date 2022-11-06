<?php

use Bws\Shortcode\Http\Controllers\ShortcodeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => get_dashboard_prefix(), 'as' => 'ajax.'], function () {
    Route::group(['prefix' => 'shortcode', 'as' => 'shortcode.'], function () {
        Route::post('get-form', [ShortcodeController::class, 'getShortcodeForm'])->name('get-form');
        Route::post('get-shortcode', [ShortcodeController::class, 'getShortcode'])->name('get-shortcode');
    });
});
