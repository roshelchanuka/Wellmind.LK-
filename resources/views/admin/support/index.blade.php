@extends('layouts.admin')

@section('page-title', 'Support Tickets')

@section('content')
<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>User Name</th>
                <th>Message</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Received</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
            <tr>
                <td>{{ $message->user_name }}</td>
                <td style="max-width: 300px;">
                    <div style="font-size: 0.9rem; color: var(--text-main);">{{ $message->feedback_text }}</div>
                </td>
                <td>
                    <div style="display: flex; color: #facc15;">
                        @for($i = 0; $i < ($message->rating ?? 0); $i++)
                        <span class="material-symbols-outlined" style="font-size: 1rem;">star</span>
                        @endfor
                    </div>
                </td>
                <td>
                    <span class="badge {{ $message->status === 'open' ? 'badge-warning' : ($message->status === 'resolved' ? 'badge-success' : 'badge-danger') }}">
                        {{ ucfirst($message->status) }}
                    </span>
                </td>
                <td>{{ $message->created_at->diffForHumans() }}</td>
                <td>
                    <form action="{{ route('admin.support.update-status', $message) }}" method="POST" style="display: flex; gap: 5px;">
                        @csrf
                        <select name="status" class="admin-input" style="padding: 2px 5px; font-size: 0.8rem; width: auto;" onchange="this.form.submit()">
                            <option value="open" {{ $message->status === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="resolved" {{ $message->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="pending" {{ $message->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px;">
        {{ $messages->links() }}
    </div>
</div>
@endsection
