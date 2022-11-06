<?php

namespace Bws\Core;

use Bws\Assets\AssetsServiceProvider;
use Bws\Core\Commands\CoreMakeModuleCommand;
use Bws\Core\Commands\CreateAdminUserCommand;
use Bws\Core\Commands\MakeRepositoryCommand;
use Bws\Core\Commands\MakeRepositoryInterfaceCommand;
use Bws\Core\Classes\Core;
use Bws\Core\Components\Alert;
use Bws\Core\Http\Middleware\CanAccessDashboardMiddleware;
use Bws\Core\Traits\CoreServiceHelper;
use Bws\Core\Traits\LoadCoreSingleton;
use Bws\Core\Traits\LoadFieldsSingleton;
use Bws\Media\MediaServiceProvider;
use Bws\Shortcode\ShortcodeServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\File;
use Bws\Core\Http\Middleware\LanguageMiddleware;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Symfony\Component\Process\Process;

class CoreServiceProvider extends PackageServiceProvider
{
    use LoadFieldsSingleton, CoreServiceHelper, LoadCoreSingleton;

    public function configurePackage(Package $package): void
    {
        $package
            ->name('bws/core')
            ->hasConfigFile()
            ->hasRoutes(['web'])
            ->hasViews('bws@core')
            ->hasAssets()
            ->hasCommands([
                CoreMakeModuleCommand::class,
                MakeRepositoryCommand::class,
                MakeRepositoryInterfaceCommand::class,
                CreateAdminUserCommand::class
            ])
            ->hasViewComponents('bwscore', Alert::class)
            ->hasTranslations()
            ->hasMigrations([
                'create_extra_users_table',
                'add_extra_columns_roles_table',
                'add_extra_columns_permissions_table',
                'add_extra_columns_notifications_table'
            ])
            ->hasInstallCommand(function (InstallCommand $command) use ($package) {
                $command
                    ->startWith(function (InstallCommand $command) use ($package) {
                        File::ensureDirectoryExists(base_path('modules'));

                        $this->updateAutoloadComposers(function ($composer) {
                            return $composer + [
                                    "Modules\\" => "modules/",
                                ];
                        });
                        $this->changeAuthMiddleware();

                        $command->callSilently("vendor:publish", [
                            '--provider' => "Spatie\Permission\PermissionServiceProvider",
                        ]);
                        $command->callSilently("notifications:table");

                        if ($command->confirm('Would you like to publish the stubs now?', false)) {
                            $command->callSilently("vendor:publish", [
                                '--tag' => "{$package->shortName()}-stubs",
                            ]);
                        }
                        if ($package->hasAssets && $command->confirm('Would you like to publish the assets now?', false)) {
                            $command->callSilently("vendor:publish", [
                                '--tag' => "{$package->shortName()}-assets",
                            ]);
                        }
                        if ($command->confirm('Would you like to publish the migrations now?', false)) {
                            $command->callSilently("vendor:publish", [
                                '--tag' => "{$package->shortName()}-migrations",
                            ]);
                        }
                        if ($command->confirm('Would you like to publish the plugin\'s assets now?', true)) {
                            foreach (config('bws/core.plugins', []) as $plugin) {
                                $command->callSilently("vendor:publish", [
                                    '--tag' => "{$plugin}-assets",
                                ]);
                            }
                        }
                        $command->callSilently("vendor:publish", [
                            '--tag' => "{$package->shortName()}-modules-stubs",
                        ]);
                    })
                    ->endWith(function (InstallCommand $command) use ($package) {
                        (new Process(['composer', 'dump-autoload'], base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
                            ->setTimeout(null)
                            ->run(function ($type, $output) use ($command) {
                                $command->info($output);
                            });
                        $command->info('Great, Let\'s make first module!');
                    });
            });
    }

    public function registeringPackage()
    {
        $this->app->singleton('bws_core', function () {
            return new Core();
        });

        if (File::exists(__DIR__ . '/../helpers/core.php')) {
            File::requireOnce(__DIR__ . '/../helpers/core.php');
        }
    }

    public function packageRegistered()
    {
        $this->registerFieldsSingleton();
        $this->registerCoreSingleton();

        $helpers = File::glob(__DIR__ . '/../helpers/*.php');
        foreach ($helpers as $helper) {
            if ($helper === (__DIR__ . '/../helpers/core.php')) {
                continue;
            }
            File::requireOnce($helper);
        }

        $this->app->register(ShortcodeServiceProvider::class);
        $this->app->register(AssetsServiceProvider::class);
        $this->app->register(MediaServiceProvider::class);
    }

    public function bootingPackage()
    {
        Paginator::useBootstrapFive();
        $this->loadKernelMiddleware();
        $this->setAccountMailActions();
    }

    public function packageBooted()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->package->basePath('/../stubs') => base_path("stubs/{$this->package->shortName()}"),
            ], "{$this->package->shortName()}-stubs");
            $this->publishes([
                $this->package->basePath('/../stubs/modules.php.stub') => config_path("modules.php"),
            ], "{$this->package->shortName()}-modules-stubs");
        }

        $this->loadDashboardMenu();
    }

    protected function loadKernelMiddleware()
    {
        $kernel = app('Illuminate\Contracts\Http\Kernel');
        $router = $this->app['router'];

        $kernel->prependMiddleware(AuthenticateSession::class);
        $kernel->prependMiddleware(StartSession::class);
        $kernel->pushMiddleware(LanguageMiddleware::class);
        $kernel->pushMiddleware(ShareErrorsFromSession::class);

        $router->aliasMiddleware('can.access.dashboard', CanAccessDashboardMiddleware::class);
    }

    public function provides()
    {
        return ['bws_core'];
    }
}
