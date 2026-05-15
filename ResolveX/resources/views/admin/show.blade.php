@extends('admin.layout')

@section('title', 'Grievance Details - ' . $grievance->ticket_id)

@section('admin-content')
<div class="stack">
    <div class="grid grid-2">
        <section class="card">
            <h2 style="margin-top:0">Grievance details</h2>
            <p><strong>Ticket ID:</strong> {{ $grievance->ticket_id }}</p>
            <p><strong>Subject:</strong> {{ $grievance->subject }}</p>
            <p><strong>Status:</strong> <span class="badge {{ str_replace(' ', '', $grievance->status) }}">{{ $grievance->status }}</span></p>
            <p><strong>Priority:</strong> <span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span></p>
            <p><strong>Category:</strong> {{ $grievance->category }}</p>
            <p><strong>AI category:</strong> {{ $grievance->ai_category ?? 'Pending' }}</p>
            <p><strong>Sentiment:</strong> <span class="badge {{ $grievance->sentiment_label ?? 'Neutral' }}">{{ $grievance->sentiment_label ?? 'Neutral' }}</span></p>
            <p><strong>SLA deadline:</strong> {{ $grievance->due_at?->format('d M Y, h:i A') ?? 'Not set' }}</p>
            <p><strong>Escalated to:</strong> {{ $grievance->escalatedTo?->name ?? 'Not escalated' }}</p>
            <p><strong>Assigned moderator:</strong> {{ $grievance->assignee?->name ?? 'Unassigned' }}</p>
            <p><strong>Submitted by:</strong>
                @if($grievance->is_anonymous)
                    Anonymous
                @else
                    {{ $grievance->user?->name ?? 'User removed' }} ({{ $grievance->user?->email ?? 'No email' }})
                @endif
            </p>
            <p><strong>Description:</strong></p>
            <p style="white-space:pre-wrap;">{{ $grievance->description }}</p>
            @if ($grievance->attachment_path)
                <a class="btn secondary" href="{{ asset('storage/'.$grievance->attachment_path) }}" target="_blank">Open attachment</a>
            @endif
        </section>

        <section class="card">
            <h2 style="margin-top:0">Moderation controls</h2>
            <form method="POST" action="{{ route('admin.grievances.update', $grievance) }}" class="grid">
                @csrf
                @method('PUT')
                <div>
                    <label>Status</label>
                    <select name="status">@foreach($statuses as $status)<option @selected($grievance->status === $status)>{{ $status }}</option>@endforeach</select>
                </div>
                <div>
                    <label>Assign to</label>
                    <select name="assigned_to">
                        <option value="">Unassigned</option>
                        @foreach ($moderators as $moderator)
                            <option value="{{ $moderator->id }}" @selected($grievance->assigned_to === $moderator->id)>{{ $moderator->name }} ({{ $moderator->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="full">
                    <label>Admin reply</label>
                    <textarea name="admin_reply" placeholder="Share progress, ask for clarification, or document decisions."></textarea>
                </div>
                <div class="full">
                    <label>Resolution summary</label>
                    <textarea name="resolution_summary">{{ old('resolution_summary', $grievance->resolution_summary) }}</textarea>
                </div>
                <button class="btn" type="submit">Save update</button>
            </form>
        </section>
    </div>

    <section class="card">
        <h2 style="margin-top:0">Timeline and chat</h2>
        <div class="timeline">
            @forelse($grievance->updates->sortByDesc('created_at') as $update)
                <div class="event">
                    <strong>{{ $update->user?->name ?? 'System' }}</strong>
                    <div class="muted">{{ $update->created_at->format('d M Y, h:i A') }} | {{ $update->status ?? 'Comment' }}</div>
                    <p>{{ $update->note }}</p>
                </div>
            @empty
                <p class="muted">No updates recorded yet.</p>
            @endforelse
        </div>
    </section>

    @if ($grievance->feedback)
        <section class="card">
            <h2 style="margin-top:0">Post-resolution feedback</h2>
            <p><strong>Rating:</strong> {{ $grievance->feedback->rating }}/5</p>
            <p>{{ $grievance->feedback->comments ?: 'No written feedback provided.' }}</p>
        </section>
    @endif
</div>
@endsection
