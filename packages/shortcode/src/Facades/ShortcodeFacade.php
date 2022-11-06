<?php

namespace Bws\Shortcode\Facades;

use Illuminate\Support\Facades\Facade;

class ShortcodeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'shortcode';
    }
}
