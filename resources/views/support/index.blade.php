@extends('layouts.app')

@section('title', 'Support - WellMind LK')

@section('styles')
<style>
    .radio {
      display: flex;
      flex-direction: row-reverse;
      justify-content: center;
      gap: 10px;
    }
    .radio input {
      display: none;
    }
    .radio label {
      cursor: pointer;
      transition: all 0.3s ease;
      color: #ccc;
    }
    .radio label svg {
      width: clamp(30px, 8vw, 45px);
      height: clamp(30px, 8vw, 45px);
      fill: currentColor;
    }
    .radio label:hover,
    .radio label:hover ~ label,
    .radio input:checked ~ label {
      color: #ffc107;
      transform: scale(1.1);
    }
    .radio label:active {
      transform: scale(0.9);
    }
    .rating-section {
      padding: 60px 20px;
      text-align: center;
      background: transparent;
      border-bottom: none;
    }
</style>
@endsection

@section('content')
  <!-- Banner Section -->
  <div class="banner-container">
      <img src="{{ asset('images/support2.jpg') }}" class="banner-img" alt="Support Banner">
      <div class="bg-card-overlay"></div>
      <div class="bg-card-content">
          <h1 class="bg-card-title" data-key="supportHeroTitle">Community Support</h1>
          <p class="bg-card-text" data-key="supportHeroText">Connect with others, share your journey, and find comfort in the shared experiences of our community.</p>
      </div>
  </div>

  <!-- Star Rating Section -->
  <section class="rating-section">
    <div class="container" style="max-width: 800px; margin: 0 auto;">
      <h3 id="ratingPromptText" data-key="ratingPrompt" style="color: #2a5421; font-size: 1.6rem; margin-bottom: 25px; font-weight: 700;">
        We’d really love to hear what you think! 😊 Please take a moment to give us your rating — it helps us grow and improve for you!
      </h3>
      
      <div class="star-rating-container">
          <div class="radio">
            @csrf
            @for ($i = 5; $i >= 1; $i--)
                <input value="{{ $i }}" name="rating-stars" type="radio" id="st-{{ $i }}" />
                <label title="{{ $i }} stars" for="st-{{ $i }}">
                  <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"></path></svg>
                </label>
            @endfor
          </div>
      </div>
      <p id="ratingStatus" data-key="ratingStatus" style="margin-top: 15px; font-weight: 600; color: #2a5421; display: none;">Thank you for your rating! 💚</p>
    </div>
  </section>

  <!-- Feedback Section -->
  <section class="container reviews-section">
    <h2 class="section-title" data-key="userFeedbacksTitle">User Feedbacks</h2>
    <div class="reviews-grid">
      @forelse($feedbacks as $row)
          <div class="review-card">
            <div class="review-header">
              <div class="review-user">
                <div class="user-avatar">{{ strtoupper(substr($row->user_name, 0, 1)) }}</div>
                <div class="user-info">
                  <h4 class="user-name">{{ $row->user_name }}</h4>
                  <p class="review-date">{{ $row->created_at->format('F j, Y, g:i a') }}</p>
                </div>
              </div>
            </div>
            <div class="review-body">
              <p class="feedback-text">{{ $row->feedback_text }}</p>
            </div>
          </div>
      @empty
          <p class="no-feedbacks" data-key="noFeedbacks">No feedbacks yet. Be the first to share your experience!</p>
      @endforelse
    </div>
  </section>

  <div class="feedback-float" id="feedbackFloat" style="bottom: clamp(20px, 10vh, 100px); z-index: 1005;">
    <div class="feedback-label">Feedback</div>
    <div class="feedback-icon-btn">
      <span class="material-symbols-outlined">chat_bubble</span>
    </div>
  </div>

  <div class="feedback-modal" id="feedbackModal">
    <div class="feedback-content">
      <div class="feedback-close" id="feedbackClose">&times;</div>
      <h3 data-key="giveFeedbackTitle">Your Feedback</h3>
      <form id="feedbackForm" class="feedback-form">
        @csrf
        <div class="form-group">
          <input type="text" name="user_name" id="fb_name" placeholder="Your Name" required 
                 data-placeholder-key="fullName"
                 value="{{ Auth::user()->full_name ?? '' }}">
        </div>
        <div class="form-group">
          <textarea name="feedback_text" id="fb_text" rows="4" placeholder="Share your experience..." required
                    data-placeholder-key="chatPlaceholder"></textarea>
        </div>
        <button type="submit" class="btn-primary" data-key="submitFeedback">Submit Feedback</button>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('input[name="rating-stars"]').forEach(input => {
      input.addEventListener('change', function() {
        const rating = this.value;
        const userName = "{{ Auth::user()->full_name ?? 'Anonymous' }}";
        const feedbackText = "Quick Star Rating";

        fetch("{{ route('save-feedback') }}", {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            user_name: userName,
            feedback_text: feedbackText,
            rating: rating
          })
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            document.getElementById('ratingStatus').style.display = 'block';
            setTimeout(() => {
              document.getElementById('ratingStatus').style.display = 'none';
            }, 3000);
          }
        });
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      const floatBtn = document.getElementById('feedbackFloat');
      const modal = document.getElementById('feedbackModal');
      const closeBtn = document.getElementById('feedbackClose');
      const form = document.getElementById('feedbackForm');

      floatBtn.addEventListener('click', () => modal.classList.add('active'));
      closeBtn.addEventListener('click', () => modal.classList.remove('active'));

      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch("{{ route('save-feedback') }}", {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
          },
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              icon: 'success',
              title: 'Thank you!',
              text: 'Your feedback has been submitted successfully.',
              confirmButtonColor: '#2A5421'
            }).then(() => {
              location.reload(); 
            });
          }
        });
      });
    });
</script>
@endsection
