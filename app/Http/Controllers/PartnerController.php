<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Playlist;

class PartnerController extends Controller
{
    public function index()
    {
        $playlists = Playlist::where('status', 'published')->get();
        return view('partner', compact('playlists'));
    }
}
