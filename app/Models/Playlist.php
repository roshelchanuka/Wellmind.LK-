<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = ['title', 'description', 'thumbnail', 'status'];

    public function mediaContents()
    {
        return $this->hasMany(MediaContent::class);
    }
}
