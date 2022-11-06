<?php

namespace Bws\Core\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notifications extends DatabaseNotification
{
    public function causer()
    {
        return $this->morphTo();
    }
}
