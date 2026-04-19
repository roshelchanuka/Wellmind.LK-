@php $hideNavbar = true; @endphp
@extends('layouts.app')

@section('title', 'Medical Device Information - WellMind LK')
@section('body-class', 'no-navbar')

@section('content')
<div class="container section-wrapper--large" style="padding: 120px 20px 60px;">
    <div style="padding: 20px 0;">
        <h1 data-key="medicalTitle" class="section-title--green" style="font-family: 'League Spartan', sans-serif; font-size: 2.5rem; margin-bottom: 20px;">Medical Device Information</h1>
        <p style="color: var(--text-muted); margin-bottom: 30px;"><span data-key="medicalLastUpdated">Last updated:</span> October 2023</p>

        <div class="section-text" style="line-height: 1.8; color: var(--text-color);">
            <div class="medical-section">
                <h2 data-key="medicalSec1Title" style="font-size: 1.5rem; margin-bottom: 10px;">1. Intended Use</h2>
                <p data-key="medicalSec1Content">WellMind.LK is a digital health application designed to support users in tracking their mood, reflections, and overall mental well-being. It is intended for self-improvement purposes.</p>
            </div>

            <div class="medical-section" style="margin-top: 30px;">
                <h2 data-key="medicalSec2Title" style="font-size: 1.5rem; margin-bottom: 10px;">2. Classification</h2>
                <p data-key="medicalSec2Content">WellMind.LK is classified as a low-risk wellness and lifestyle tool. It is not currently registered as a high-risk medical device. Our goal is accessible digital support.</p>
            </div>

            <div class="alert-box" style="margin: 40px 0; padding: 25px; background: rgba(248, 113, 113, 0.15); border-left: 5px solid #f87171; border-radius: 10px;">
                <strong style="color: #f87171;" data-key="medicalAlertTitle">IMPORTANT:</strong>
                <p style="margin-top: 10px; font-weight: 500;" data-key="medicalAlertContent">WellMind.LK is NOT a crisis intervention tool or a medical diagnostic service. If you are experiencing a mental health emergency, please contact your local emergency services immediately.</p>
            </div>

            <div class="medical-section" style="margin-top: 30px;">
                <h2 data-key="medicalSec3Title" style="font-size: 1.5rem; margin-bottom: 10px;">3. Professional Advice</h2>
                <p data-key="medicalSec3Content">The information provided should not be used as a substitute for professional medical advice, diagnosis, or treatment. Always seek the advice of your physician.</p>
            </div>

            <div class="medical-section" style="margin-top: 30px;">
                <h2 data-key="medicalSec4Title" style="font-size: 1.5rem; margin-bottom: 10px;">4. Quality and Compliance</h2>
                <p data-key="medicalSec4Content">We are committed to maintaining high standards of data security and user safety. Our team continuously reviews our tools to adhere to digital health guidelines.</p>
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
