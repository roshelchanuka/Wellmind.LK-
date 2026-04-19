<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    public function show($id)
    {
        $playlist = Playlist::with('mediaContents')->findOrFail($id);
        
        return view('playlists.show', compact('playlist'));
    }
}
