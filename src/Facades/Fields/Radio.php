<?php

namespace Bws\Core\Facades\Fields;

use Illuminate\Support\Facades\Facade;

class Radio extends Facade
{
    protected static $cached = false;

    protected static function getFacadeAccessor()
    {
        return 'Radio';
    }
}
