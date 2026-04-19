@php $hideNavbar = true; @endphp
@extends('layouts.app')

@section('title', 'Privacy Policy - WellMind LK')
@section('body-class', 'no-navbar')

@section('content')
<div class="container section-wrapper--large" style="padding: 120px 20px 60px;">
    <div style="padding: 20px 0;">
        <h1 data-key="privacyTitle" class="section-title--green" style="font-family: 'League Spartan', sans-serif; font-size: 2.5rem; margin-bottom: 20px;">Privacy Policy</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;"><span data-key="privacyLastUpdated">Last updated:</span> October 2023</p>

        <div class="section-text" style="line-height: 1.8; color: var(--text-color);">
            <div class="privacy-section">
                <h2 data-key="privacySec1Title" style="font-size: 1.5rem; margin-bottom: 10px;">1. General Information</h2>
                <p data-key="privacySec1Content">Protection of your personal data is a top priority for WellMind.LK. This privacy policy explains how we collect and use your personal information when you use our website or services.</p>
            </div>

            <div class="privacy-section" style="margin-top: 30px;">
                <h2 data-key="privacySec2Title" style="font-size: 1.5rem; margin-bottom: 10px;">2. Data Collection</h2>
                <p data-key="privacySec2Content">We collect information that you provide to us directly, such as when you create an account, track your mood, or contact us. This may include your name, email, and mood history.</p>
            </div>

            <div class="privacy-section" style="margin-top: 30px;">
                <h2 data-key="privacySec3Title" style="font-size: 1.5rem; margin-bottom: 10px;">3. Data Usage</h2>
                <p data-key="privacySec3Content">Your data is used specifically for providing and maintaining our services, analyzing trends to improve user experience, and communicating about your account.</p>
            </div>

            <div class="privacy-section" style="margin-top: 30px;">
                <h2 data-key="privacySec4Title" style="font-size: 1.5rem; margin-bottom: 10px;">4. Data Security</h2>
                <p data-key="privacySec4Content">We use industry-standard security measures to protect your data. Your mood logs are encrypted and stored securely to ensure privacy and confidentiality.</p>
            </div>

            <div class="privacy-section" style="margin-top: 30px;">
                <h2 data-key="privacySec5Title" style="font-size: 1.5rem; margin-bottom: 10px;">5. Cookies</h2>
                <p data-key="privacySec5Content">WellMind.LK uses cookies to enhance your experience. These small files help the site remember your preferences and settings.</p>
            </div>

            <div class="privacy-section" style="margin-top: 30px;">
                <h2 data-key="privacySec6Title" style="font-size: 1.5rem; margin-bottom: 10px;">6. Your Rights</h2>
                <p data-key="privacySec6Content">You have the right to access, update, or delete your personal data at any time. If you have questions, please contact our support team.</p>
            </div>

            <div style="margin-top: 50px;">
                <a href="{{ route('home') }}" class="back-link" style="color: var(--primary-color); text-decoration: none; display: flex; align-items: center; gap: 10px;">
                    <span class="material-symbols-outlined">arrow_back</span>
                    <span data-key="backHome">Back to Home</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
