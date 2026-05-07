@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <h1 class="title">{{ $grievance->ticket_id }}</h1>
        <p class="subtitle">{{ $grievance->subject }}</p>
    </div>
    <a class="btn secondary" href="{{ route('grievances.index') }}">Back</a>
</div>

<section class="grid grid-2">
    <div class="card">
        <h2 style="margin-top:0">Ticket details</h2>
        <p><strong>Status:</strong> {{ $grievance->status }}</p>
        <p><strong>Priority:</strong> <span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span></p>
        <p><strong>Category:</strong> {{ $grievance->category }}</p>
        <p><strong>Submitted by:</strong> {{ $grievance->is_anonymous ? 'Anonymous' : ($grievance->user?->name ?? 'User removed') }}</p>
        <p><strong>Assigned to:</strong> {{ $grievance->assignee?->name ?? 'Unassigned' }}</p>
        <p>{{ $grievance->description }}</p>
        @if ($grievance->attachment_path)
            <p><a class="btn secondary" href="{{ asset('storage/'.$grievance->attachment_path) }}" target="_blank">View attachment</a></p>
        @endif
    </div>

    <div class="card">
        <h2 style="margin-top:0">Admin controls</h2>
        @if (auth()->user()->isStaff())
            <form method="POST" action="{{ route('grievances.update', $grievance) }}" class="grid">
                @csrf
                @method('PUT')
                <div>
                    <label>Status</label>
                    <select name="status">@foreach($statuses as $status)<option @selected($grievance->status===$status)>{{ $status }}</option>@endforeach</select>
                </div>
                <div>
                    <label>Assign moderator</label>
                    <select name="assigned_to">
                        <option value="">Unassigned</option>
                        @foreach ($moderators as $moderator)
                            <option value="{{ $moderator->id }}" @selected($grievance->assigned_to === $moderator->id)>{{ $moderator->name }} ({{ $moderator->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Progress note</label>
                    <textarea name="note"></textarea>
                </div>
                <button class="btn" type="submit">Update ticket</button>
            </form>
        @else
            <p class="muted">Only admin and moderators can assign or change ticket status.</p>
        @endif
    </div>
</section>

<section class="grid grid-2" style="margin-top:16px">
    <div class="card">
        <h2 style="margin-top:0">Timeline</h2>
        <div class="timeline">
            @foreach ($grievance->updates as $update)
                <div class="event">
                    <strong>{{ $update->status ?? 'Comment' }}</strong>
                    <div class="muted">{{ $update->created_at->format('d M Y, h:i A') }} by {{ $update->user?->name ?? 'System' }}</div>
                    <p>{{ $update->note }}</p>
                </div>
            @endforeach
        </div>
        <form method="POST" action="{{ route('grievances.comments.store', $grievance) }}" class="grid" style="margin-top:18px">
            @csrf
            <label>Add comment</label>
            <textarea name="note" required></textarea>
            <button class="btn secondary" type="submit">Post comment</button>
        </form>
    </div>

    <div class="card">
        <h2 style="margin-top:0">Feedback</h2>
        @if ($grievance->feedback)
            <p><strong>Rating:</strong> {{ $grievance->feedback->rating }}/5</p>
            <p>{{ $grievance->feedback->comments }}</p>
        @elseif ($grievance->status === 'Resolved' && $grievance->user_id === auth()->id())
            <form method="POST" action="{{ route('feedback.store', $grievance) }}" class="grid">
                @csrf
                <div>
                    <label>Rating</label>
                    <select name="rating">@for($i=5; $i>=1; $i--)<option value="{{ $i }}">{{ $i }}</option>@endfor</select>
                </div>
                <div>
                    <label>Comments</label>
                    <textarea name="comments"></textarea>
                </div>
                <button class="btn" type="submit">Submit feedback</button>
            </form>
        @else
            <p class="muted">Feedback opens after the ticket is resolved.</p>
        @endif
    </div>
</section>
@endsection
