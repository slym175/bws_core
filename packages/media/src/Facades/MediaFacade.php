<?php

namespace Bws\Media\Facades;

use Illuminate\Support\Facades\Facade;

class MediaFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'bws_media';
    }
}
