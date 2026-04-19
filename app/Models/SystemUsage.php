<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemUsage extends Model
{
    protected $table = 'system_usage';

    protected $fillable = ['user_id', 'action', 'device_info'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
