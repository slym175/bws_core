<?php

namespace Bws\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ModelTypeFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'model_type';
    }
}
