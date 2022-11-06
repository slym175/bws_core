<?php

use Bws\Core\Http\Controllers\ACL\PermissionController;
use Bws\Core\Http\Controllers\AdminAjaxController;
use Bws\Core\Http\Controllers\Auth\ForgotPasswordController;
use Bws\Core\Http\Controllers\Auth\LoginController;
use Bws\Core\Http\Controllers\Auth\RegisterController;
use Bws\Core\Http\Controllers\Auth\ResetPasswordController;
use Bws\Core\Http\Controllers\Auth\VerificationController;
use Bws\Core\Http\Controllers\DebugController;
use Bws\Core\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => get_dashboard_prefix(), 'as' => 'admin.'], function () {
    Route::get('/', get_dashboard_action())->name('dashboard');

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    if (can_create_account()) {
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    }

    Route::group(['prefix' => 'email', 'as' => 'verification.'], function () {
        Route::get('verify', [VerificationController::class, 'show'])->name('notice');
        Route::get('verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verify');
        Route::post('resend', [VerificationController::class, 'resend'])->name('resend');
    });

    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('request');
        Route::post('email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email');
        Route::get('reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('reset');
        Route::post('reset', [ResetPasswordController::class, 'reset'])->name('update');
    });

    Route::post('logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('languages/{language}', [LanguageController::class, 'setLanguage'])
        ->name('languages.update');

    Route::group(['prefix' => '_debug', 'as' => '_debug.'], function () {
        Route::get('cache-clear', [DebugController::class, 'cacheClear'])
            ->name('cache-clear');

        Route::get('optimize-clear', [DebugController::class, 'optimizeClear'])
            ->name('optimize-clear');

        Route::get('purge-assets', [DebugController::class, 'purgeAssets'])
            ->name('purge-assets');
    });

    Route::group(['prefix' => 'ajax', 'as' => 'ajax.'], function () {
        Route::post('do-action', AdminAjaxController::class)
            ->name('do-action');
    });

    Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
        Route::get('/', [PermissionController::class, 'index'])->name('list');
//        Route::get('/create', [PermissionController::class, 'create'])->name('create');
//        Route::post('/create', [PermissionController::class, 'store'])->name('store');
//        Route::get('/detail/{id}', [PermissionController::class, 'show'])->name('show');
//        Route::get('/update/{id}', [PermissionController::class, 'edit'])->name('edit');
//        Route::put('/update/{id}', [PermissionController::class, 'update'])->name('update');
//        Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('destroy');
    });
});
