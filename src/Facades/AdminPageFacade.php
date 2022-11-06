<?php

namespace Bws\Core\Facades;

use Illuminate\Support\Facades\Facade;

class AdminPageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'admin_page';
    }
}
