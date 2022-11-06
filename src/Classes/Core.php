<?php

namespace Bws\Core\Classes;

use Illuminate\Support\Facades\Route;

class Core
{
    public function routerUrl($name, $parameters = [], $absolute = true)
    {
        if (!Route::has($name) || $name === '') {
            return '';
        }
        return route($name, $parameters, $absolute);
    }
}
