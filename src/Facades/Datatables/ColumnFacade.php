<?php

namespace Bws\Core\Facades\Datatables;

use Illuminate\Support\Facades\Facade;

class ColumnFacade extends Facade
{
    protected static $cached = false;

    protected static function getFacadeAccessor()
    {
        return "Datatable_Column";
    }
}
