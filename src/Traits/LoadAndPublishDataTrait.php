<?php

namespace Bws\Core\Traits;

use Exception;
use ReflectionClass;

trait LoadAndPublishDataTrait
{
    protected $namespace = null;
    protected $basePath = null;

    public function setNamespace($namespace)
    {
        $this->namespace = ltrim(rtrim($namespace, '/'), '/');

        return $this;
    }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param array|string $fileNames
     * @return $this
     * @throws Exception
     */
    public function loadAndPublishConfigurations($fileNames)
    {
        if (!is_array($fileNames)) {
            $fileNames = [$fileNames];
        }
        foreach ($fileNames as $fileName) {
            $this->mergeConfigFrom(base_path($this->getConfigFilePath($fileName)), $this->getDotedNamespace() . '.' . $fileName);
            if ($this->app->runningInConsole()) {
                $this->publishes([
                    base_path($this->getConfigFilePath($fileName)) => config_path($this->getDashedNamespace() . '/' . $fileName . '.php'),
                ], 'bws-'.$this->getKebabNamespace().'-config');
            }
        }

        return $this;
    }

    /**
     * Get path of the give file name in the given module
     * @param string $file
     * @return string
     * @throws Exception
     */
    protected function getConfigFilePath($file)
    {
        $file = $this->getBasePath() . $this->getDashedNamespace() . '/config/' . $file . '.php';
        if (!file_exists($file) && str_contains($file, package_path())) {
            $this->throwInvalidPluginError();
        }

        return $file;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $path
     * @return $this
     */
    public function setBasePath($path)
    {
        $this->basePath = $path;

        return $this;
    }

    /**
     * @return string
     */
    protected function getDashedNamespace()
    {
        return str_replace('.', '/', $this->namespace);
    }

    /**
     * @return string
     */
    protected function getDotedNamespace()
    {
        return str_replace('/', '.', $this->namespace);
    }

    /**
     * @return string
     */
    protected function getKebabNamespace()
    {
        return str_replace('/', '-', $this->namespace);
    }

    /**
     * Publish the given configuration file name (without extension) and the given module
     * @param array|string $fileNames
     * @return $this
     */
    public function loadRoutes($fileNames = ['web'])
    {
        if (!is_array($fileNames)) {
            $fileNames = [$fileNames];
        }

        foreach ($fileNames as $fileName) {
            $this->loadRoutesFrom(base_path($this->getRouteFilePath($fileName)));
        }

        return $this;
    }

    /**
     * @param string $file
     * @return string
     */
    protected function getRouteFilePath($file)
    {
        $file = $this->getBasePath() . $this->getDashedNamespace() . '/routes/' . $file . '.php';

        if (!file_exists($file) && str_contains($file, package_path())) {
            $this->throwInvalidPluginError();
        }

        return $file;
    }

    /**
     * @return $this
     */
    public function loadAndPublishViews()
    {
        $this->loadViewsFrom(base_path($this->getViewsPath()), $this->getDashedNamespace());
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [base_path($this->getViewsPath()) => resource_path('views/vendor/' . $this->getDashedNamespace())],
                'bws-'.$this->getKebabNamespace().'-views'
            );
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getViewsPath()
    {
        return $this->getBasePath() . $this->getDashedNamespace() . '/resources/views/';
    }

    /**
     * @return $this
     */
    public function loadAndPublishTranslations()
    {
        $this->loadTranslationsFrom($this->getTranslationsPath(), $this->getDashedNamespace());
        $this->publishes([$this->getTranslationsPath() => resource_path('lang/vendor/' . $this->getDashedNamespace())],
            'bws-'.$this->getKebabNamespace().'-lang');

        return $this;
    }

    /**
     * @return string
     */
    protected function getTranslationsPath()
    {
        return $this->getBasePath() . $this->getDashedNamespace() . '/resources/lang/';
    }

    /**
     * @return $this
     */
    public function loadMigrations()
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());

        return $this;
    }

    /**
     * @return string
     */
    protected function getMigrationsPath()
    {
        return $this->getBasePath() . $this->getDashedNamespace() . '/database/migrations/';
    }

    /**
     * @param string|null $path
     * @return $this
     */
    public function publishAssets($path = null)
    {
        if ($this->app->runningInConsole()) {
            if (empty($path)) {
                $path = 'vendor/bws/' . $this->getDashedNamespace();
            }
            $this->publishes([$this->getAssetsPath() => public_path($path)], 'bws-'.$this->getKebabNamespace().'-assets');
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function getAssetsPath()
    {
        return $this->getBasePath() . $this->getDashedNamespace() . '/public/';
    }

    /**
     * @throws Exception
     */
    protected function throwInvalidPluginError()
    {
        $reflection = new ReflectionClass($this);

        $from = str_replace('/src/Providers', '', dirname($reflection->getFilename()));
        $from = str_replace(base_path(), '', $from);

        $to = $this->getBasePath() . $this->getDashedNamespace();
        $to = str_replace(base_path(), '', $to);

        if ($from != $to) {
            throw new Exception(sprintf('Plugin folder is invalid. Need to rename folder %s to %s', $from, $to));
        }
    }
}
