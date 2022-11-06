<?php

namespace Bws\Media\Facades;

use Illuminate\Support\Facades\Facade;

class MediaHelperFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bws_helper';
    }
}
