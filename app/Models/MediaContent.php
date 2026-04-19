<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaContent extends Model
{
    protected $fillable = ['playlist_id', 'title', 'type', 'url', 'duration'];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
