<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailReminder extends Model
{
    protected $fillable = ['user_id', 'reminder_type', 'reminder_time', 'is_sent'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
