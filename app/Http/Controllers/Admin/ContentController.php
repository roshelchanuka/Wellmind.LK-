<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playlist;
use App\Models\MediaContent;

class ContentController extends Controller
{
    public function index()
    {
        $playlists = Playlist::withCount('mediaContents')->get();
        return view('admin.content.index', compact('playlists'));
    }

    public function storePlaylist(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
        ]);

        Playlist::create($validated);
        return back()->with('success', 'Playlist created successfully.');
    }

    public function storeMedia(Request $request)
    {
        $validated = $request->validate([
            'playlist_id' => 'required|exists:playlists,id',
            'title' => 'required|string|max:255',
            'type' => 'required|in:audio,video',
            'url' => 'required|url',
            'duration' => 'nullable|string',
        ]);

        MediaContent::create($validated);
        return back()->with('success', 'Media content added successfully.');
    }
}
