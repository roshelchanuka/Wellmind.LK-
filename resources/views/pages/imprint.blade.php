@php $hideNavbar = true; @endphp
@extends('layouts.app')

@section('title', 'Imprint - WellMind LK')
@section('body-class', 'no-navbar')

@section('content')
<div class="container section-wrapper--large" style="padding: 120px 20px 60px;">
    <div style="padding: 20px 0;">
        <h1 data-key="imprintTitle" class="section-title--green" style="font-family: 'League Spartan', sans-serif; font-size: 2.5rem; margin-bottom: 30px;">Imprint</h1>
        
        <div class="section-text" style="line-height: 2; color: var(--text-color);">
            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintName" style="font-size: 1.4rem;">WellMind.LK</b>
            </div>

            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintAddrLabel" style="color: var(--primary-color);">Address:</b>
                <p data-key="imprintAddrVal">No. 25, Galle Road, Colombo 03, Sri Lanka</p>
            </div>

            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintEmailLabel" style="color: var(--primary-color);">E-Mail:</b>
                <p data-key="imprintEmailVal">support@wellmind.lk</p>
            </div>

            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintDirectorLabel" style="color: var(--primary-color);">Managing Director:</b>
                <p data-key="imprintDirectorVal">Chanuka Fernando</p>
            </div>

            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintRegLabel" style="color: var(--primary-color);">Registration Number:</b>
                <p data-key="imprintRegVal">PV 123456</p>
            </div>

            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintVatLabel" style="color: var(--primary-color);">VAT-ID:</b>
                <p data-key="imprintVatVal">LK123456789</p>
            </div>

            <div class="imprint-section" style="margin-bottom: 20px;">
                <b data-key="imprintDataLabel" style="color: var(--primary-color);">Data Protection Contact:</b>
                <p data-key="imprintDataVal">privacy@wellmind.lk</p>
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
