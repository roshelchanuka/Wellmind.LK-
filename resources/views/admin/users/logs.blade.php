@extends('layouts.admin')

@section('page-title', 'User Activity Logs: ' . $user->full_name)

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('admin.users.index') }}" class="admin-btn" style="background: rgba(255,255,255,0.1); text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
        <span class="material-symbols-outlined" style="font-size: 1.2rem;">arrow_back</span> Back to Users
    </a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Action</th>
                <th>Device Info</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr>
                <td><span style="color: var(--primary-color);">{{ $log->action }}</span></td>
                <td>{{ $log->device_info }}</td>
                <td style="color: var(--text-muted);">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center; padding: 40px; color: var(--text-muted);">No activity logs found for this user.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
