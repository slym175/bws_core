<?php

namespace Bws\Core\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardMenuFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dashboard_menu';
    }
}
