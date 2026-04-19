@extends('layouts.app')

@section('title', 'WellMind LK - Partner')

@section('content')
  <!-- Banner Section -->
  <div class="banner-container">
    <img src="{{ asset('images/background1.jpg') }}" class="banner-img" alt="Partner Banner">
    <div class="bg-card-overlay"></div>
    <div class="bg-card-content">
      <h1 class="bg-card-title" data-key="partnerPageHeader">Partner with WellMind.LK</h1>
      <p class="bg-card-text" data-key="partnerPageSubtext">Help young people take care of their mental well-being in a simple and supportive way.</p>
    </div>
  </div>

  <main class="main-content">
    <!-- Music Section -->
    <section class="music-section partner-main-content">
      <div class="partner-header">
        <h2 data-key="musicSectionTitle" class="partner-title">Mood Fixing Songs Playlist 🎵</h2>
        <p data-key="musicSectionDesc" class="partner-desc">Sometimes music is the best medicine. Choose a playlist below to help lift your spirits and find focus.</p>
      </div>

      <div class="partner-flex">
        <!-- Left: Featured Image -->
        <div style="flex: 1; min-width: 300px;" class="scroll-animate">
          <img src="{{ asset('images/Listen.jpg') }}" alt="Listen" class="partner-featured-img">
        </div>

        <!-- Right: Playlist Cards Grid -->
        <div style="flex: 1.5; min-width: 350px;">
          <div class="playlist-grid">
            
            @forelse($playlists as $playlist)
            <div class="card scroll-animate playlist-card">
              @if($playlist->thumbnail)
                <img src="{{ $playlist->thumbnail }}" alt="{{ $playlist->title }}" class="playlist-card__img">
              @else
                <span class="playlist-card__placeholder">🎵</span>
              @endif
              <h3 class="playlist-card__title">{{ $playlist->title }}</h3>
              <p class="playlist-card__desc">{{ Str::limit($playlist->description, 60) }}</p>
              <a href="{{ route('playlists.show', $playlist->id) }}" class="btn-primary btn-listen">Listen Now</a>
            </div>
            @empty
            <div style="text-align: center; width: 100%; color: #999;">
                <p>New mood fixing playlists are coming soon!</p>
            </div>
            @endforelse

          </div>
        </div>
      </div>

      <!-- Integrated Help Section -->
      <div class="help-section">
        <div class="card mb-3 scroll-animate help-card">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="{{ asset('images/image1.jpg') }}" class="img-fluid rounded-start help-card__img" alt="Help">
            </div>
            <div class="col-md-8">
              <div class="card-body help-card__body">
                <h5 class="card-title help-card__title" data-key="helpTitle">It's okay to ask for help</h5>
                <p class="card-text help-card__text" data-key="helpBody">You don't have to face everything alone. Sometimes it's okay to feel lost, tired, or overwhelmed. Talking to someone can make things better. We're here for you — always.</p>
                <p class="card-text"><small class="text-muted">Stay Strong 💚</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>
@endsection
