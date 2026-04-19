@extends('layouts.admin')

@section('page-title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label" data-key="totalUsers">Total Users</div>
        <div class="stat-value">{{ $stats['total_users'] }}</div>
        <div class="stat-trend stat-trend--positive">+12% from last month</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" data-key="activeUsers">Active Users</div>
        <div class="stat-value">{{ $stats['active_users'] }}</div>
        <div class="stat-trend stat-trend--neutral">Currently verified</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" data-key="moodEntriesToday">Mood Entries Today</div>
        <div class="stat-value">{{ $stats['mood_entries_today'] }}</div>
        <div class="stat-trend stat-trend--info">Daily activity spike</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" data-key="openTickets">Open Tickets</div>
        <div class="stat-value">{{ $stats['open_tickets'] }}</div>
        <div class="stat-trend stat-trend--negative">Needs attention</div>
    </div>
    <div class="stat-card">
        <div class="stat-label" data-key="dailyVisitors">Daily Visitors</div>
        <div class="stat-value">{{ $stats['visitors_today'] }}</div>
        <div class="stat-trend stat-trend--purple">Total activity today</div>
    </div>
</div>

<div class="dashboard-charts">
    <div class="admin-card">
        <h3 class="card-title--no-margin">System Activity (Last 7 Days)</h3>
        <canvas id="activityChart" height="200"></canvas>
    </div>
    <div class="admin-card">
        <h3 class="card-title--no-margin">Mood Distribution</h3>
        <canvas id="moodChart" height="200"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Activity Chart
    const activityCtx = document.getElementById('activityChart').getContext('2d');
    new Chart(activityCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($activityTrend->pluck('date')) !!},
            datasets: [{
                label: 'Interactions',
                data: {!! json_encode($activityTrend->pluck('count')) !!},
                borderColor: '#749D62',
                backgroundColor: 'rgba(116, 157, 98, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#94a3b8' } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
            }
        }
    });

    // Mood Chart
    const moodCtx = document.getElementById('moodChart').getContext('2d');
    new Chart(moodCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($moodDistribution->pluck('mood')) !!},
            datasets: [{
                data: {!! json_encode($moodDistribution->pluck('count')) !!},
                backgroundColor: ['#749D62', '#60a5fa', '#facc15', '#f87171', '#a78bfa'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom', labels: { color: '#94a3b8' } }
            }
        }
    });
</script>
@endsection
