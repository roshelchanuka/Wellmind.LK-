@extends('layouts.admin')

@section('page-title', 'User Management')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 35px; height: 35px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            {{ substr($user->full_name, 0, 1) }}
                        </div>
                        {{ $user->full_name }}
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td><span class="badge {{ $user->role === 'admin' ? 'badge-warning' : 'badge-success' }}" style="background: rgba(147, 197, 253, 0.1); color: #93c5fd;">{{ ucfirst($user->role) }}</span></td>
                <td>
                    <span class="badge {{ $user->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td style="display: flex; gap: 10px;">
                    <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="admin-btn" style="background: {{ $user->status === 'active' ? '#f87171' : '#4ade80' }}; padding: 5px 10px; font-size: 0.8rem;">
                            {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <a href="{{ route('admin.users.logs', $user) }}" class="admin-btn" style="background: rgba(255,255,255,0.1); padding: 5px 10px; font-size: 0.8rem; text-decoration: none;">Logs</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection
