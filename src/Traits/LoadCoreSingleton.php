<?php

namespace Bws\Core\Traits;

use Bws\Core\Classes\AdminPage;
use Bws\Core\Classes\DashboardMenu;
use Bws\Core\Classes\Form\Form;
use Bws\Core\Classes\Hook;
use Bws\Core\Classes\ModelType;
use Bws\Core\Models\Repositories\PermissionRepository;
use Bws\Core\Models\Repositories\PermissionRepositoryInterface;

trait LoadCoreSingleton
{
    protected function registerCoreSingleton() {
        $this->app->singleton('hook', function () {
            return new Hook();
        });
        $this->app->singleton('model_type', function () {
            return new ModelType();
        });
        $this->app->singleton('dashboard_menu', function () {
            return new DashboardMenu();
        });
                $this->app->singleton('form', function () {
            return new Form();
        });
        $this->app->singleton('admin_page', function () {
            return new AdminPage();
        });
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }
}
