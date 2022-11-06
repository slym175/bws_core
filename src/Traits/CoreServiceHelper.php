<?php

namespace Bws\Core\Traits;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

trait CoreServiceHelper
{
    protected static function updateAutoloadComposers(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('composer.json'))) {
            return;
        }

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);


        $composer['autoload']['psr-4'] = $callback(
            array_key_exists('autoload', $composer) ? $composer['autoload']['psr-4'] : [],
            'autoload'
        );

        ksort($composer['autoload']['psr-4']);

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    protected function changeAuthMiddleware()
    {
        $authenticateMiddleware = file_get_contents(app_path('Http/Middleware/Authenticate.php'));

        $modifiedAuthenticateMiddleware = Str::replace(
            "return route('login');",
            "if (!@substr_compare(\Illuminate\Support\Facades\Request::path(), get_dashboard_prefix(), 0, strlen(get_dashboard_prefix())) == 0) {
                return route('login');
            }
            return route('admin.login');",
            $authenticateMiddleware
        );

        file_put_contents(app_path('Http/Middleware/Authenticate.php'), $modifiedAuthenticateMiddleware);
    }

    protected function loadDashboardMenu()
    {
        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->addMenuItem([
                'id' => 'bws_core_dashboard_page',
                'priority' => -9999,
                'parent_id' => 'general_section',
                'name' => 'bws/core::core.menu.dashboard',
                'icon' => 'bi bi-speedometer2',
                'url' => router_url('admin.dashboard'),
                'permissions' => ['access-dashboard'],
            ])->addMenuItem([
                'id' => 'bws_core_acl_page',
                'priority' => 2,
                'parent_id' => 'general_section',
                'name' => 'bws/core::core.menu.acl',
                'icon' => 'bi bi-speedometer2',
                'url' => 'javascript:;',
                'permissions' => ['access-dashboard'],
            ])->addMenuItem([
                'id' => 'bws_core_acl_permission_page',
                'priority' => 1,
                'parent_id' => 'bws_core_acl_page',
                'name' => 'bws/core::core.menu.permission',
                'icon' => 'bi bi-speedometer2',
                'url' => router_url('admin.permission.list'),
                'permissions' => ['access-dashboard'],
            ]);
        });
    }

    protected function setAccountMailActions()
    {
        VerifyEmail::createUrlUsing(function ($notifiable) {
            $verifyUrl = URL::temporarySignedRoute(
                'admin.verification.verify',
                Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            return $verifyUrl;
        });

        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            return url(route('admin.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });
    }
}
