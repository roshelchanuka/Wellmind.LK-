@extends('layouts.app')

@section('title', 'Your Profile - WellMind LK')

@section('content')
  <!-- Banner Section -->
  <div class="banner-container">
    <img src="{{ asset('images/profile.jpg') }}" class="banner-img" alt="Profile Banner">
    <div class="bg-card-overlay"></div>
    <div class="bg-card-content">
      <h1 class="bg-card-title" data-key="profileHeroTitle">Profile Settings</h1>
      <p class="bg-card-text" data-key="profileHeroText">Manage your account information and preferences.</p>
    </div>
  </div>

  <!-- Profile Content -->
  <main class="main-content">
    <section class="profile-section" style="padding: 40px 20px;">
      <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 50px; align-items: flex-start;">
        
        <!-- Left Side: Profile Photo -->
        <div class="profile-photo-container" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; align-items: center; text-align: center;">
          <div class="profile-pic-wrapper" id="profilePicWrapper" style="position: relative; width: 220px; height: 220px; border-radius: 50%; border: 5px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.2); overflow: hidden; background: #eee; cursor: pointer;">
            <img src="{{ $profilePhotoUrl }}" alt="Profile Photo" id="profileImage" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="pic-overlay" style="position: absolute; bottom: 0; left: 0; width: 100%; background: rgba(0,0,0,0.6); color: white; padding: 8px 0; font-size: 0.8rem; transform: translateY(100%); transition: transform 0.3s ease;">
              <span class="material-symbols-outlined" style="font-size: 1.2rem;">photo_camera</span><br>Change Photo
            </div>
          </div>
          
          <form action="{{ route('update-photo') }}" method="POST" enctype="multipart/form-data" id="photoForm" style="display: none;">
            @csrf
            <input type="file" name="profile_photo" id="photoInput" accept="image/png, image/jpeg, image/jpg">
          </form>

          <h3 style="margin-top: 20px; color: #2a5421; font-size: 1.8rem;">{{ $user->full_name }}</h3>
          <p style="color: #666; font-size: 1.1rem;">{{ $user->email }}</p>
          
          <div style="margin-top: 25px;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-secondary" data-key="logout" style="padding: 10px 25px; border-radius: 30px; font-weight: bold; cursor: pointer; border: none;">Logout</button>
            </form>
          </div>
        </div>
        
        <!-- Right Side: Account Details -->
        <div class="profile-info-list" style="flex: 2; min-width: 350px;">
          <h2 data-key="profileDetails" style="color: #2a5421; margin-bottom: 25px; font-size: 1.8rem; border-bottom: 2px solid #749D62; padding-bottom: 10px; display: inline-block;">Account Details</h2>
          
          <div class="details-grid" style="display: grid; gap: 15px;">
            <div class="detail-row" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; justify-content: space-between;">
              <span data-key="fullNameLabel" style="font-weight: bold; color: #555;">Full Name</span>
              <span style="color: #2a5421; font-weight: 500;">{{ $user->full_name }}</span>
            </div>
            
            <div class="detail-row" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; justify-content: space-between;">
              <span data-key="emailLabel" style="font-weight: bold; color: #555;">Email Address</span>
              <span style="color: #2a5421; font-weight: 500;">{{ $user->email }}</span>
            </div>
            
            <div class="detail-row" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; justify-content: space-between;">
              <span data-key="ageLabel" style="font-weight: bold; color: #555;">Age</span>
              <span style="color: #2a5421; font-weight: 500;">{{ $user->age ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; justify-content: space-between;">
              <span data-key="dobLabel" style="font-weight: bold; color: #555;">Date of Birth</span>
              <span style="color: #2a5421; font-weight: 500;">{{ $user->dob ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display: flex; justify-content: space-between;">
              <span data-key="genderLabel" style="font-weight: bold; color: #555;">Gender</span>
              <span style="color: #2a5421; font-weight: 500;">{{ ucfirst($user->gender ?? 'N/A') }}</span>
            </div>
          </div>
        </div>

      </div>
    </section>
  </main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profilePicWrapper = document.getElementById('profilePicWrapper');
        const photoInput = document.getElementById('photoInput');
        const photoForm = document.getElementById('photoForm');

        if (profilePicWrapper && photoInput) {
            profilePicWrapper.addEventListener('click', () => {
                photoInput.click();
            });
        }

        if (photoInput && photoForm) {
            photoInput.addEventListener('change', () => {
                photoForm.submit();
            });
        }
    });
</script>
@endsection

