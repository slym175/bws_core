<?php

namespace Bws\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'model_id', 'model_type', 'action', 'description', 'details', 'old_details', 'ip_address'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
