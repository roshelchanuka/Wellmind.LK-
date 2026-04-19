@extends('layouts.app')

@section('title', 'WellMind LK - ' . $playlist->title)

@section('content')
<,StartLine:5,TargetContent:<div class="playlist-banner" style="background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('images/background1.jpg') }}');">
    <div class="banner-text">
        <h1 class="playlist-banner__title">{{ $playlist->title }}</h1>
        <p class="playlist-banner__sub">{{ $playlist->mediaContents->count() }} Mood Fixing Items</p>
    </div>
</div>

<div class="playlist-content">
    <div class="playlist-content__header">
        <p class="playlist-content__desc">
            {{ $playlist->description }}
        </p>
        <div class="playlist-content__divider"></div>
    </div>

    <div class="media-list">
        @forelse($playlist->mediaContents as $content)
            <a href="{{ $content->url }}" target="_blank" class="media-card">
                <div class="media-icon">
                    <span class="material-symbols-outlined">
                        {{ $content->type === 'video' ? 'play_circle' : 'music_note' }}
                    </span>
                </div>
                <div class="media-info">
                    <div class="media-title">{{ $content->title }}</div>
                    <div class="media-meta">
                        {{ strtoupper($content->type) }} • {{ $content->duration ?? 'Duration Unknown' }}
                    </div>
                </div>
                <div class="listen-btn">
                    Listen Now
                </div>
            </a>
        @empty
            <div class="playlist-empty-state">
                <span class="material-symbols-outlined playlist-empty-state__icon">music_off</span>
                <p>This playlist is empty. Check back soon!</p>
            </div>
        @endforelse
    </div>

    <div class="playlist-footer">
        <a href="{{ route('partner') }}" class="playlist-back-link">
            <span class="material-symbols-outlined">arrow_back</span> Back to All Playlists
        </a>
    </div>
</div>
@endsection
