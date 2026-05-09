@extends('admin.layout')

@section('title', 'Grievance Details - ' . $grievance->ticket_id)

@section('admin-content')
<div class="grid grid-2 gap-6">
    <!-- Grievance Details -->
    <div class="card">
        <h2 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">Grievance Details</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="font-weight: bold;">Ticket ID:</label>
                <p>{{ $grievance->ticket_id }}</p>
            </div>

            <div>
                <label style="font-weight: bold;">Status:</label>
                <p><span class="badge">{{ $grievance->status }}</span></p>
            </div>

            <div>
                <label style="font-weight: bold;">Priority:</label>
                <p><span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span></p>
            </div>

            <div>
                <label style="font-weight: bold;">Category:</label>
                <p><span class="badge">{{ $grievance->category }}</span></p>
            </div>

            <div class="full">
                <label style="font-weight: bold;">Subject:</label>
                <p>{{ $grievance->subject }}</p>
            </div>

            <div class="full">
                <label style="font-weight: bold;">Description:</label>
                <p style="white-space: pre-wrap;">{{ $grievance->description }}</p>
            </div>

            <div>
                <label style="font-weight: bold;">Submitted:</label>
                <p>{{ $grievance->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div>
                <label style="font-weight: bold;">User:</label>
                <p>
                    @if($grievance->is_anonymous)
                        <span class="badge">Anonymous</span>
                    @else
                        <strong>{{ $grievance->user->name }}</strong><br>
                        <small style="color: var(--muted);">{{ $grievance->user->email }}</small>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Update Status & Reply -->
    <div class="card">
        <h2 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">Update & Reply</h2>

        <form method="POST" action="{{ route('admin.grievances.update', $grievance) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 16px;">
                <label for="status" style="display: block; font-weight: bold; margin-bottom: 6px;">Status:</label>
                <select name="status" id="status" style="width: 100%;">
                    <option value="Submitted" {{ $grievance->status === 'Submitted' ? 'selected' : '' }}>Submitted</option>
                    <option value="Under Review" {{ $grievance->status === 'Under Review' ? 'selected' : '' }}>Under Review</option>
                    <option value="In Progress" {{ $grievance->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="Resolved" {{ $grievance->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>

            <div style="margin-bottom: 16px;">
                <label for="admin_reply" style="display: block; font-weight: bold; margin-bottom: 6px;">Admin Reply:</label>
                <textarea name="admin_reply" id="admin_reply" rows="6" placeholder="Type your reply to the user here..."></textarea>
            </div>

            <div style="display: flex; gap: 12px;">
                <button type="submit" class="btn">💾 Save Changes</button>
                <a href="{{ route('admin.dashboard') }}" class="btn secondary">⬅️ Back to Dashboard</a>
            </div>
        </form>
    </div>
</div>

<!-- Previous Updates/Replies -->
@if($grievance->updates->count() > 0)
<div class="card" style="margin-top: 24px;">
    <h2 style="margin-bottom: 20px; font-size: 20px; font-weight: bold;">Communication History</h2>

    <div class="timeline">
        @foreach($grievance->updates->sortByDesc('created_at') as $update)
            <div class="event">
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                    <strong>{{ $update->user->name }}</strong>
                    <small style="color: var(--muted);">{{ $update->created_at->diffForHumans() }}</small>
                </div>
                <div style="color: var(--muted); font-size: 12px; margin-bottom: 8px;">
                    Status: {{ $update->status ?? 'Update' }}
                </div>
                <p>{{ $update->note }}</p>
            </div>
        @endforeach
    </div>
</div>
@endif
@endsection
