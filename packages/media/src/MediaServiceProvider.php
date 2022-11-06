<?php

namespace Bws\Media;

use Bws\Media\Facades\MediaFacade;
use Bws\Media\Facades\MediaHelperFacade;
use Bws\Media\Repositories\Eloquent\MediaSettingRepository;
use Bws\Media\Models\MediaFile;
use Bws\Media\Models\MediaFolder;
use Bws\Media\Models\MediaSetting;
use Bws\Media\Repositories\Caches\MediaFileCacheDecorator;
use Bws\Media\Repositories\Caches\MediaFolderCacheDecorator;
use Bws\Media\Repositories\Caches\MediaSettingCacheDecorator;
use Bws\Media\Repositories\Eloquent\MediaFileRepository;
use Bws\Media\Repositories\Eloquent\MediaFolderRepository;
use Bws\Media\Repositories\Interfaces\MediaFileInterface;
use Bws\Media\Repositories\Interfaces\MediaFolderInterface;
use Bws\Media\Repositories\Interfaces\MediaSettingInterface;
use Bws\Media\Services\ThumbnailService;
use Bws\Media\Services\UploadsManager;
use Bws\Media\Supports\Helper;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Intervention\Image\ImageManager;
use Mimey\MimeTypes;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MediaServiceProvider extends PackageServiceProvider
{
    public function registeringPackage()
    {
        $files = \File::glob(__DIR__ . '/../helpers/*');
        foreach ($files as $file) {
            \File::requireOnce($file);
        }
    }

    public function packageRegistered()
    {
        AliasLoader::getInstance()->alias('Media', MediaFacade::class);
        AliasLoader::getInstance()->alias('MediaHelper', MediaHelperFacade::class);

        $this->app->bind('bws_media', function () {
            $driver = 'gd';
            if (extension_loaded('imagick')) {
                $driver = 'imagick';
            }
            return new Media(new MediaFileCacheDecorator(
                new MediaFileRepository(new MediaFile),
                'Bws\Media\Repositories'
            ), new MediaFolderCacheDecorator(
                new MediaFolderRepository(new MediaFolder),
                'Bws\Media\Repositories'
            ), new UploadsManager(new MimeTypes()),
                new ThumbnailService(
                    new UploadsManager(new MimeTypes()),
                    new ImageManager(compact('driver'))
                )
            );
        });

        $this->app->bind('bws_helper', function () {
            return new Helper();
        });

        $this->app->bind(MediaFileInterface::class, function () {
            return new MediaFileCacheDecorator(
                new MediaFileRepository(new MediaFile),
                'Bws\Media\Repositories'
            );
        });

        $this->app->bind(MediaFolderInterface::class, function () {
            return new MediaFolderCacheDecorator(
                new MediaFolderRepository(new MediaFolder),
                'Bws\Media\Repositories'
            );
        });

        $this->app->bind(MediaSettingInterface::class, function () {
            return new MediaSettingCacheDecorator(
                new MediaSettingRepository(new MediaSetting),
                'Bws\Media\Repositories'
            );
        });
    }

    public function packageBooted()
    {
        Blade::directive('singleImage', function ($expression) {
            $expressions = explode(',',str_replace(' ', '', $expression));
            list($field_name, $values) = $expressions;

            return "<?php echo view('bws@media::partials.image-box', [
                'name' => ".$field_name.",
                'values' => ".$values.",
            ])->render() ?>";
        });

        Blade::directive('multipleImages', function ($expression) {
            $expressions = explode(',',str_replace(' ', '', $expression));
            list($field_name, $value, $attributes) = $expressions;

            return "<?php echo view('bws@media::partials.images-box', [
                'name' => ".$field_name.",
                'values' => ".$value.",
                'attributes' => ".$attributes.",
            ])->render() ?>";
        });

        Event::listen(RouteMatched::class, function () {
            dashboard_menu()->addMenuItem([
                'id' => 'bws_core_media_page',
                'priority' => -1000,
                'parent_id' => 'general_section',
                'name' => 'bws/core::core.menu.medias_manager',
                'icon' => 'bi bi-picture',
                'url' => router_url('admin.media.index'),
                'permissions' => ['access-dashboard'],
            ]);
        });
    }

    public function configurePackage(Package $package): void
    {
        $package->name('bws/media')
            ->hasConfigFile()
            ->hasTranslations()
            ->hasViews('bws@media')
            ->hasAssets()
            ->hasRoute('web')
            ->hasMigration('create_media_tables');
    }
}
