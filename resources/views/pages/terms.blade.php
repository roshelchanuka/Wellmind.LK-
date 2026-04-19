@php $hideNavbar = true; @endphp
@extends('layouts.app')

@section('title', 'Terms and Conditions - WellMind LK')
@section('body-class', 'no-navbar')

@section('content')
<div class="container section-wrapper--large" style="padding: 120px 20px 60px;">
    <div style="padding: 20px 0;">
        <h1 data-key="termsTitle" class="section-title--green" style="font-family: 'League Spartan', sans-serif; font-size: 2.5rem; margin-bottom: 20px;">Terms and Conditions</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;"><span data-key="termsLastUpdated">Last updated:</span> October 2023</p>
        
        <div class="section-text" style="line-height: 1.8; color: var(--text-color);">
            <div class="terms-section">
                <h2 data-key="termsSec1Title" style="font-size: 1.5rem; margin-bottom: 10px;">1. Acceptance of Terms</h2>
                <p data-key="termsSec1Content">By accessing or using WellMind.LK, you agree to comply with and be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our services.</p>
            </div>

            <div class="terms-section" style="margin-top: 30px;">
                <h2 data-key="termsSec2Title" style="font-size: 1.5rem; margin-bottom: 10px;">2. Use of Services</h2>
                <p data-key="termsSec2Content">WellMind.LK provides tools for mood tracking and mental health reflection. These services are for personal and non-commercial use only. You must not use the services for any illegal or unauthorized purposes.</p>
            </div>

            <div class="terms-section" style="margin-top: 30px;">
                <h2 data-key="termsSec3Title" style="font-size: 1.5rem; margin-bottom: 10px;">3. User Responsibilities</h2>
                <p data-key="termsSec3Content">You are responsible for maintaining the confidentiality of your account information. Any activity that occurs under your account is your sole responsibility.</p>
            </div>

            <div class="terms-section" style="margin-top: 30px;">
                <h2 data-key="termsSec4Title" style="font-size: 1.5rem; margin-bottom: 10px;">4. Accuracy of Information</h2>
                <p data-key="termsSec4Content">While we strive to provide accurate information, WellMind.LK makes no warranties regarding the accuracy, completeness, or reliability of any content on the site.</p>
            </div>

            <div class="terms-section" style="margin-top: 30px;">
                <h2 data-key="termsSec5Title" style="font-size: 1.5rem; margin-bottom: 10px;">5. Limitation of Liability</h2>
                <p data-key="termsSec5Content">WellMind.LK and its team shall not be liable for any direct, indirect, incidental, or consequential damages resulting from the use or inability to use our services.</p>
            </div>

            <div class="terms-section" style="margin-top: 30px;">
                <h2 data-key="termsSec6Title" style="font-size: 1.5rem; margin-bottom: 10px;">6. Governing Law</h2>
                <p data-key="termsSec6Content">These terms are governed by and construed in accordance with the laws of Sri Lanka, without regard to its conflict of law principles.</p>
            </div>

            <div class="terms-section" style="margin-top: 30px;">
                <h2 data-key="termsSec7Title" style="font-size: 1.5rem; margin-bottom: 10px;">7. Changes to Terms</h2>
                <p data-key="termsSec7Content">We reserve the right to modify these Terms and Conditions at any time. Your continued use of the services after changes are posted constitutes your acceptance of the new terms.</p>
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
