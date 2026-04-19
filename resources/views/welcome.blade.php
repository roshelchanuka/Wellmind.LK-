@extends('layouts.app')

@section('title', 'WellMind LK - Your Mental Health Companion')

@php
    $bgImage = 'Afternoon.jpg';
    $greetingKey = 'greeting_afternoon';
    $fallback_greeting = 'Good Afternoon';
@endphp

@section('content')
  <div class="banner-container" id="heroSection">
    <img src="{{ asset('images/' . $bgImage) }}" class="banner-img" alt="Home Banner">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <div class="dynamic-greeting hero__greeting" id="greetingText" data-key="{{ $greetingKey }}">
        {{ $fallback_greeting }}
      </div>
      <h1 class="pop-in" data-key="homeTitle">Welcome to WellMind LK</h1>
      <p class="pop-in" data-key="homeText">
        Your personal mental health companion. Share your feelings, track your mood, and receive thoughtful advice entirely in your preferred language.</p>
      
      <div class="hero-buttons pop-in">
        @guest
            <a href="{{ route('login') }}" class="btn-primary" data-key="loginNow">Login Now</a>
            <a href="{{ route('register') }}" class="btn-secondary" data-key="createAccount">Create Account</a>
        @else
            <a href="{{ route('add-mood') }}" class="btn-primary">Track Your Mood</a>
        @endguest
      </div>
    </div>
  </div>

  <main class="main-content">
    <section class="support-info support-section reveal">
      <div class="container support-container">
          <h2 data-key="supportMsgTitle" class="support-title">Support Throughout Your Mental Health Journey</h2>
          <p data-key="supportMsgBody" class="support-text">Whether you want to improve your mental well-being, track your mood in real time, or strengthen the techniques you've learned, WellMind.LK is here to support you every step of the way.</p>

          <div class="card-group feature-card-group">
            @php
              $cards = [
                'lady.jpg' => ['key' => 'ladyCardText', 'text' => 'Capture your brightest moments. Every smile tells a story worth remembering.'],
                'hands.jpg' => ['key' => 'handsCardText', 'text' => 'You are never alone. Reach out, connect, and find the support you need.'],
                'videoframe_3004.png' => ['key' => 'videoCardText', 'text' => "It's okay not to be okay. Tracking your lows is the first step toward healing."]
              ];
            @endphp
            @foreach($cards as $img => $data)
            <div class="card feature-card">
                <img src="{{ asset('images/'.$img) }}" alt="Support" class="feature-card__img">
                <div class="card-body feature-card__body">
                    <p class="card-text feature-card__text" data-key="{{ $data['key'] }}">{{ $data['text'] }}</p>
                </div>
            </div>
            @endforeach
          </div>

          <!-- New Stretch Image Card -->
          <div class="stretch-section section-wrapper--large reveal">
            <div style="flex: 1; min-width: 300px;">
              <img src="{{ asset('images/Stretch.jpg') }}" alt="Stretch" style="width: 100%; height: auto; border-radius: 16px; object-fit: cover; display: block;">
            </div>
            <div style="flex: 2; min-width: 300px;">
              <h5 data-key="stretchCardTitle" class="section-title--green">Self-Care for Your Mental Well-Being</h5>
              <p data-key="stretchCardText" class="section-text">WellMind.LK is designed for individuals who want to take care of their mental health, manage emotional challenges, or support themselves after being diagnosed with a mental health condition.</p>
            </div>
          </div>

          <!-- New Mood Image Card -->
          <div class="mood-insight-section insight-grid reveal">
            <div class="insight-content">
              <h3 data-key="moodMainTitle" class="insight-title">Focus on Your Emotional Well-Being with WellMind.LK</h3>
              
              <div class="insight-item">
                <h5 data-key="moodSub1Title" class="insight-item__title">Understand Your Thoughts and Feelings</h5>
                <p data-key="moodSub1Text" class="insight-item__text">With regular check-ins throughout the day, WellMind.LK helps you reflect on your emotions and provides personalized audio guidance and resources tailored to your needs.</p>
              </div>

              <div class="insight-item">
                <h5 data-key="moodSub2Title" class="insight-item__title">Discover Your Patterns</h5>
                <p data-key="moodSub2Text" class="insight-item__text">Clear and simple visual insights help you recognize emotional patterns and guide you toward improving your well-being.</p>
              </div>

              <div class="insight-item">
                <h5 data-key="moodSub3Title" class="insight-item__title">Gain Deeper Insight into Your Mental Health</h5>
                <p data-key="moodSub3Text" class="insight-item__text">Consistent feedback helps you identify challenges and better understand your mental health journey.</p>
              </div>

              <div class="insight-item">
                <h5 data-key="moodSub4Title" class="insight-item__title">Take Positive Action</h5>
                <p data-key="moodSub4Text" class="insight-item__text">Access helpful resources to set goals, manage difficult emotions, reduce stress, care for your emotional needs, and build healthier relationships.</p>
              </div>
            </div>
            <div class="insight-image-wrapper">
              <img src="{{ asset('images/mood.png') }}" alt="Mood Tracker" class="insight-image">
            </div>
          </div>

          <!-- Overthinking Section -->
          <div class="always-there-section callout-banner reveal" style="background-image: url('{{ asset('images/background1.jpg') }}');">
            <div class="callout-banner__overlay"></div>
            <div class="callout-banner__content">
              <h2 data-key="background1Title" class="callout-banner__title">WellMind.LK Is Always There for You</h2>
              <p data-key="background1Text" class="callout-banner__text">No matter where you are in your mental health journey, WellMind.LK is here to support, guide, and care for you anytime you need it.</p>
            </div>
          </div>

          <!-- Self-Guided Support Section -->
          <div class="self-guided-section" style="margin: 60px auto; max-width: 1200px; padding: 0 20px; text-align: center;">
            <h2 data-key="selfGuidedTitle" class="section-title--green" style="font-size: 2rem;">Self-Guided Support with WellMind.LK</h2>
            <p data-key="selfGuidedDesc" class="section-text" style="max-width: 900px; margin: 0 auto;">WellMind.LK guides you through effective coping strategies for a wide range of challenges, including depression, burnout, anxiety, phobias, insomnia, and eating-related difficulties.</p>
          </div>

          <!-- Small Acts of Self-Care Section -->
          <div class="self-care-section reveal" style="margin: 80px auto 40px; max-width: 1200px; padding: 0 20px; text-align: center;">
            <h2 data-key="selfCareTitle" class="support-title" style="margin-bottom: 50px;">Small Acts of Self-Care 🌿</h2>
            @php
              $care = [
                'breaths.jpg' => ['key' => 'care1', 'text' => 'Take a deep breath and let it go.'],
                'Listen.jpg' => ['key' => 'care2', 'text' => 'Listen to your favorite calming music.'],
                'Drink.jpg' => ['key' => 'care3', 'text' => 'Stay hydrated and drink enough water.'],
                'walk.jpg' => ['key' => 'care4', 'text' => 'Go for a short walk in nature.']
              ];
            @endphp
            <div class="self-care-grid">
              @foreach($care as $img => $data)
              <div class="self-care-item">
                <img src="{{ asset('images/'.$img) }}" class="self-care-item__img" alt="Self Care">
                <p data-key="{{ $data['key'] }}" class="self-care-item__text">{{ $data['text'] }}</p>
              </div>
              @endforeach
            </div>
          </div>

          <!-- Take the First Step Section -->
          <div class="step-today-section action-card reveal">
            <div class="action-card__flex">
              <div class="action-card__content">
                  <h5 class="action-card__title" data-key="startTodayTitle">Take the First Step Today</h5>
                  <p class="action-card__text" data-key="startTodayDesc">Start Today and Understand Yourself Better</p>
                  <div class="radio" style="margin-top: 30px; display: flex; flex-direction: row-reverse; justify-content: flex-end; gap: 10px;">
                    @for($i=5; $i>=1; $i--)
                    <input value="{{$i}}" name="rating" type="radio" id="rating-{{$i}}" style="display:none;" />
                    <label title="{{$i}} stars" for="rating-{{$i}}" style="cursor:pointer; color:#ccc; transition:0.3s;">
                      <svg xmlns="http://www.w3.org/2000/svg" height="1.5em" viewBox="0 0 576 512" fill="currentColor"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                    </label>
                    @endfor
                  </div>
              </div>
              <div class="action-card__image-wrapper">
                <img src="{{ asset('images/start.png') }}" class="action-card__img" alt="Step">
              </div>
            </div>
          </div>

          <!-- Partner Section -->
          <div class="partner-section partner-banner" style="background-image: url('{{ asset('images/mCare.jpg') }}');">
            <div class="callout-banner__overlay"></div>
            <div class="partner-banner__content">
              <h2 data-key="partnerTitle" class="callout-banner__title">Make Mental Health Care Easy</h2>
              <p data-key="partnerDesc" class="callout-banner__text">We support improving mental health and well-being through simple and effective care.</p>
              <div style="margin-top: 30px;">
                <a href="{{ route('partner') }}" data-key="learnMore" class="partner-btn">Learn More</a>
              </div>
            </div>
          </div>

      </div>
    </section>
  </main>
@endsection
