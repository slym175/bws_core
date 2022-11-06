<?php

namespace Bws\Core\Models;

use Bws\Core\Traits\HashIdTrait;
use Bws\Core\Traits\ModelLogging;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoreModel extends Model
{
    use HasFactory, HashIdTrait, ModelLogging;

    public function getPerPage()
    {
        return config('app.per_page', 10);
    }
}
