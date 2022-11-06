<?php

namespace Bws\Assets;

use Bws\Assets\Commands\Purge;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AssetsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('bws/assets')
            ->hasConfigFile();
    }

    public function packageRegistered()
    {
        $this->app->singleton('assets', function ($app) {

            $filesystem = new Filesystem(new LocalFilesystemAdapter(public_path(), PortableVisibilityConverter::fromArray([
                'file' => [
                    'public' => 0640,
                    'private' => 0604,
                ],
                'dir' => [
                    'public' => 0740,
                    'private' => 7604,
                ],
            ])));

            return new Assets($app['config']['bws/assets'], $filesystem);
        });

        $this->app->bind('command.assets.purge', function (Application $app) {
            return new Purge($app->make('assets'));
        });

        $this->commands(['command.assets.purge']);
    }

    public function packageBooted()
    {
        if (File::exists(__DIR__ . '/../helpers/assets.php')) {
            File::requireOnce(__DIR__ . '/../helpers/assets.php');
        }
    }
}
