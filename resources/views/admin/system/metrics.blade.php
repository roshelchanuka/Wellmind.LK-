@extends('layouts.admin')

@section('page-title', 'System Metrics & Notifications')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 25px;">
    <!-- System Logs -->
    <div class="admin-card">
        <h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px;">
            <span class="material-symbols-outlined">history</span> <span data-key="activityLogs">Activity Logs</span>
        </h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user->full_name ?? 'Guest' }}</td>
                    <td><span style="color: var(--primary-color);">{{ $log->action }}</span></td>
                    <td style="font-size: 0.8rem; color: var(--text-muted);">{{ $log->created_at->diffForHumans() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px;">{{ $logs->links() }}</div>
    </div>

    <!-- Notification Monitor -->
    <div class="admin-card">
        <h3 style="margin-top: 0; display: flex; align-items: center; gap: 10px;">
            <span class="material-symbols-outlined">notifications_active</span> <span data-key="notificationMonitor">Notification Monitor</span>
        </h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notif)
                <tr>
                    <td>{{ $notif->user->full_name ?? 'System' }}</td>
                    <td><span style="font-size: 0.85rem;">{{ $notif->reminder_type }}</span></td>
                    <td>
                        <span class="badge {{ $notif->is_sent ? 'badge-success' : 'badge-warning' }}" data-key="{{ $notif->is_sent ? 'notifSent' : 'notifPending' }}">
                            {{ $notif->is_sent ? 'Sent' : 'Pending' }}
                        </span>
                    </td>
                    <td style="font-size: 0.8rem; color: var(--text-muted);">{{ $notif->reminder_time }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top: 15px;">{{ $notifications->links() }}</div>
    </div>
</div>
@endsection
