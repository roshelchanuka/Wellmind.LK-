@extends('layouts.admin')

@section('page-title', 'Content Manager')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 25px;">
    <!-- Playlist Creation -->
    <div class="admin-card">
        <h3 style="margin-top: 0;">Create New Playlist</h3>
        <form action="{{ route('admin.content.playlists.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Playlist Title</label>
                <input type="text" name="title" class="admin-input" placeholder="e.g. Sleep Meditations" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Description</label>
                <textarea name="description" class="admin-input" rows="3"></textarea>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Thumbnail URL</label>
                <input type="text" name="thumbnail" class="admin-input" placeholder="https://image-url.com">
            </div>
            <button type="submit" class="admin-btn" style="width: 100%;">Create Playlist</button>
        </form>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid var(--glass-border);">

        <h3 style="margin-top: 0;">Add Media Content</h3>
        <form action="{{ route('admin.content.media.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Select Playlist</label>
                @if($playlists->count() > 0)
                    <select name="playlist_id" class="admin-input" style="color: white; background: #1e293b;" required>
                        @foreach($playlists as $playlist)
                            <option value="{{ $playlist->id }}" style="background: #1e293b; color: white;">{{ $playlist->title }}</option>
                        @endforeach
                    </select>
                @else
                    <div style="color: var(--text-muted); font-size: 0.8rem; padding: 10px; border: 1px dashed var(--glass-border); border-radius: 10px;">
                        No playlists found. Create one first!
                    </div>
                @endif
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Media Title</label>
                <input type="text" name="title" class="admin-input" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Type</label>
                <select name="type" class="admin-input" required>
                    <option value="audio">Audio</option>
                    <option value="video">Video</option>
                </select>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 0.9rem;">Media URL</label>
                <input type="url" name="url" class="admin-input" placeholder="https://..." required>
            </div>
            <button type="submit" class="admin-btn" style="width: 100%;">Add to Playlist</button>
        </form>
    </div>

    <!-- Playlist List -->
    <div class="admin-card">
        <h3 style="margin-top: 0;">Existing Playlists</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Items</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($playlists as $playlist)
                <tr>
                    <td>
                        <div style="font-weight: bold;">{{ $playlist->title }}</div>
                        <div style="font-size: 0.8rem; color: var(--text-muted);">{{ Str::limit($playlist->description, 50) }}</div>
                    </td>
                    <td><span class="badge" style="background: rgba(255,255,255,0.05);">{{ $playlist->media_contents_count }} items</span></td>
                    <td><span class="badge badge-success">{{ ucfirst($playlist->status) }}</span></td>
                    <td>
                        <button class="admin-btn" style="background: rgba(255,255,255,0.1); padding: 5px 10px; font-size: 0.8rem;">Edit</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">No playlists created yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
