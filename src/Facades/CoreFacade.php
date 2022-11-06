<?php

namespace Bws\Core\Facades;

use Illuminate\Support\Facades\Facade;

class CoreFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bws_core';
    }
}
