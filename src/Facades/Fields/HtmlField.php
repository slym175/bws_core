<?php

namespace Bws\Core\Facades\Fields;

use Illuminate\Support\Facades\Facade;

class HtmlField extends Facade
{
    protected static $cached = false;

    protected static function getFacadeAccessor()
    {
        return 'HtmlField';
    }
}
