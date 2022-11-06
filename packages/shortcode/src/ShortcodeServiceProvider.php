<?php

namespace Bws\Shortcode;

use Bws\Shortcode\Models\ShortcodeCompiler;
use Bws\Shortcode\Views\Factory;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ShortcodeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('bws/shortcode')
            ->hasConfigFile()
            ->hasRoutes(['web'])
            ->hasViews('bws@shortcode')
            ->hasAssets()
            ->hasTranslations();
    }

    public function registeringPackage()
    {
        $this->loadAlias();
        $this->registerShortcodeCompiler();
        $this->registerShortcode();
        $this->registerView();
    }

    public function packageRegistered()
    {
        $helpers = File::glob(__DIR__ . '/../helpers/*.php');
        foreach ($helpers as $helper) {
            if ($helper === (__DIR__ . '/../helpers/core.php')) {
                continue;
            }
            File::requireOnce($helper);
        }
    }

    public function loadAlias() {
        $loader = AliasLoader::getInstance();
        $loader->alias('Shortcode', 'Bws\\Shortcode\\Facades\\Shortcode');
    }

    public function registerShortcodeCompiler()
    {
        $this->app->singleton('shortcode.compiler', function ($app) {
            return new ShortcodeCompiler();
        });
    }

    public function registerShortcode()
    {
        $this->app->singleton('shortcode', function ($app) {
            return new Shortcode($app['shortcode.compiler']);
        });
    }

    public function registerView()
    {
        $finder = $this->app['view']->getFinder();

        $this->app->singleton('view', function ($app) use ($finder) {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];
            $env = new Factory($resolver, $finder, $app['events'], $app['shortcode.compiler']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);
            $env->share('app', $app);

            return $env;
        });
    }

    public function provides()
    {
        return [
            'shortcode',
            'shortcode.compiler',
            'view'
        ];
    }
}
