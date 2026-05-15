@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <h1 class="title">Notifications</h1>
        <p class="subtitle">Track complaint submissions, status changes, escalations, and replies.</p>
    </div>
    <form method="POST" action="{{ route('notifications.read-all') }}">
        @csrf
        <button class="btn secondary" type="submit">Mark all as read</button>
    </form>
</div>

<section class="card">
    <div class="timeline">
        @forelse ($notifications as $notification)
            <div class="event">
                <strong>{{ $notification->data['title'] ?? 'Update' }}</strong>
                <div class="muted">
                    {{ $notification->created_at->format('d M Y, h:i A') }}
                    @if (! $notification->read_at)
                        • Unread
                    @endif
                </div>
                <p>{{ $notification->data['message'] ?? 'New activity available.' }}</p>
                @if (! empty($notification->data['grievance_id']))
                    <a class="btn secondary" href="{{ route('grievances.show', $notification->data['grievance_id']) }}">Open ticket</a>
                @endif
            </div>
        @empty
            <p class="muted">No notifications yet.</p>
        @endforelse
    </div>

    <div style="margin-top:16px;">
        {{ $notifications->links() }}
    </div>
</section>
@endsection
