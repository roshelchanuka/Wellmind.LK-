@extends('layouts.app')

@section('title', 'Add Mood - WellMind LK')
@section('bg-image', asset('images/addmood.jpg'))

@section('content')
    <!-- Banner Section -->
    <div class="banner-container">
        <img src="{{ asset('images/addmood.jpg') }}" class="banner-img" alt="Add Mood Banner">
        <div class="bg-card-overlay"></div>
        <div class="bg-card-content">
            <h1 class="bg-card-title" data-key="addMoodHeroTitle">Share Your Feelings</h1>
            <p class="bg-card-text" data-key="addMoodHeroText">Express yourself openly and honestly to understand your emotions better.</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="main-content chat-layout">
        <!-- Chatbox Container -->
        <div class="chat-container">
            <div class="chat-header">
                <div class="bot-info">
                    <div class="bot-avatar">
                        <img src="{{ asset('images/websitelogo.jpg') }}" alt="Bot">
                    </div>
                    <div class="bot-text">
                        <p class="status-dot">Online</p>
                    </div>
                </div>
                <button id="refreshChat" class="refresh-btn" title="Clear Chat">
                    <span class="material-symbols-outlined">refresh</span>
                </button>
            </div>

            <div class="chat-messages" id="chatbox">
                <div class="message bot-message">
                    <div class="msg-bubble">
                        <p data-key="chatIntro">Hello! I'm here to listen. How are you feeling today?</p>
                    </div>
                    <span class="msg-time">Just now</span>
                </div>
            </div>

            <div class="chat-input-area">
                @csrf
                <input type="text" id="userInput" placeholder="Type how you feel..." data-key="chatPlaceholder">
                <button id="sendBtn" class="send-btn">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </div>
        </div>

        <!-- Motivational Cards -->
        <div class="container scroll-animate motivational-wrapper">
            <div class="card mb-3 motivational-card">
                <div class="row g-0 motivational-row">
                    <div class="col-md-5 motivational-image-col">
                        <img src="{{ asset('images/selfmotivation.jpg') }}" class="img-fluid motivational-img" alt="Self Motivation">
                    </div>
                    <div class="col-md-7 motivational-content-col">
                        <div class="card-body motivational-body">
                            <h5 class="card-title motivational-title" data-key="moodMotivationalTitle">Stay Strong & Keep Growing</h5>
                            <p class="card-text motivational-text" data-key="moodMotivationalText1">Everyone faces challenges in life, and it’s okay to feel overwhelmed sometimes. What matters most is not giving up.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
    // Link JS to the new Laravel API endpoint
    window.moodSaveUrl = "{{ route('save-mood') }}";
</script>
@endsection
