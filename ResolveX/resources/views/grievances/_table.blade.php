<div style="overflow:auto">
    <table class="table">
        <thead>
            <tr>
                <th>Ticket</th>
                <th>Subject</th>
                <th>Category</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Sentiment</th>
                <th>Owner</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grievances as $grievance)
                <tr>
                    <td><a href="{{ route('grievances.show', $grievance) }}"><strong>{{ $grievance->ticket_id }}</strong></a></td>
                    <td>{{ $grievance->subject }}</td>
                    <td>{{ $grievance->category }}</td>
                    <td><span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span></td>
                    <td>
                        {{ $grievance->status }}
                        @if($grievance->escalated_at)
                            <div class="muted" style="font-size:12px;">Escalated</div>
                        @endif
                    </td>
                    <td><span class="badge {{ $grievance->sentiment_label ?? 'Neutral' }}">{{ $grievance->sentiment_label ?? 'Neutral' }}</span></td>
                    <td>{{ $grievance->is_anonymous ? 'Anonymous' : ($grievance->user?->name ?? 'User removed') }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">No grievances found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
