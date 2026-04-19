@extends('layouts.app')

@section('title', 'Mood History - WellMind LK')

@section('content')
    <!-- Banner Section -->
    <div class="banner-container">
        <img src="{{ asset('images/history.jpg') }}" class="banner-img" alt="Mood History Banner">
        <div class="bg-card-overlay"></div>
        <div class="bg-card-content">
            <h1 class="bg-card-title" data-key="historyHeroTitle">Mood History & Journey</h1>
            <p class="bg-card-text" data-key="historyHeroText">Reflect on your emotional progress, view your previous entries, and see how far you've come on your journey to mental wellness.</p>
        </div>
    </div>

    <!-- Main Content -->
    <section class="container history-section">
        <div class="mood-container history-container">

            <!-- Filter Bar -->
            <div class="filter-section">
                <div class="date-input-group">
                    <label data-key="startDate">Start Date</label>
                    <input type="date" id="historyStartDate">
                </div>
                <div class="date-input-group">
                    <label data-key="endDate">End Date</label>
                    <input type="date" id="historyEndDate">
                </div>
                <button class="filter-btn" id="historyFilterBtn" data-key="filterBtn">Filter</button>
                <button class="clear-btn" id="historyClearBtn" data-key="clearBtn">✕ Clear</button>
            </div>

            <!-- Loading State -->
            <div class="history-loading" id="historyLoading">
                <div class="spinner"></div>
                <span>Loading your mood history...</span>
            </div>

            <!-- Data Table -->
            <div class="table-responsive" id="historyTableWrapper" style="display:none;">
                <table class="mood-table">
                    <thead>
                        <tr>
                            <th data-key="dateCol">Date</th>
                            <th data-key="timeCol">Time</th>
                            <th data-key="moodCol">Mood</th>
                            <th data-key="noteCol">Note</th>
                            <th data-key="actionCol">Action</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            <div class="empty-state" id="historyEmptyState" style="display:none;">
                <span class="empty-state-icon">📅</span>
                <p data-key="noHistory">No mood logs found for this period.</p>
            </div>
        </div>
    </section>

    <!-- Believe Motivation Section -->
    <div class="believe-container">
        <img src="{{ asset('images/believe.jpg') }}" alt="Believe in Yourself" class="believe-img">
        <div class="believe-overlay">
            <div class="believe-text" data-key="believeMsg">
                Stay positive. Keep moving forward.
            </div>
        </div>
    </div>

    <!-- Welcome Popup -->
    <div id="historyWelcomeOverlay" class="hw-overlay">
        <div class="hw-modal" id="historyWelcomeModal">
            <span class="hw-orb hw-orb--1"></span>
            <span class="hw-orb hw-orb--2"></span>
            <span class="hw-orb hw-orb--3"></span>
            <div class="hw-icon-wrap">
                <span class="hw-icon">📊</span>
            </div>
            <h2 class="hw-title">Welcome to Your Mood Journal</h2>
            <p class="hw-sub">Here you can explore, filter, and manage all your recorded moods in one place. 🌿</p>
            <div class="hw-stats" id="hwStats">
                <div class="hw-stat-item">
                    <span class="hw-stat-num" id="hwTotalEntries">—</span>
                    <span class="hw-stat-label">Total Entries</span>
                </div>
                <div class="hw-stat-divider"></div>
                <div class="hw-stat-item">
                    <span class="hw-stat-num" id="hwLatestMood">—</span>
                    <span class="hw-stat-label">Latest Mood</span>
                </div>
                <div class="hw-stat-divider"></div>
                <div class="hw-stat-item">
                    <span class="hw-stat-num" id="hwLatestDate">—</span>
                    <span class="hw-stat-label">Last Entry</span>
                </div>
            </div>
            <button class="hw-btn" id="hwCloseBtn">Let's Go &rarr;</button>
            <div class="hw-progress-wrap">
                <div class="hw-progress-bar" id="hwProgressBar"></div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Laravel API Routes for History
    window.moodHistoryUrl = "{{ route('get-history') }}";
    window.moodDeleteUrl = "{{ route('delete-mood') }}";
</script>
@endsection
