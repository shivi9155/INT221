<div>
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
                    <td><a href="{{ route('grievances.show', $grievance) }}" style="color: var(--brand); font-weight: 800;">{{ $grievance->ticket_id }}</a></td>
                    <td style="font-size: 14px;">{{ $grievance->subject }}</td>
                    <td style="font-size: 13px; opacity: 0.7;">{{ $grievance->category }}</td>
                    <td><span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span></td>
                    <td>
                        <span style="font-size: 13px; font-weight: 700;">{{ $grievance->status }}</span>
                        @if($grievance->escalated_at)
                            <div style="font-size: 10px; color: #ef4444; font-weight: 800; text-transform: uppercase; margin-top: 2px;">Escalated</div>
                        @endif
                    </td>
                    <td><span class="badge {{ $grievance->sentiment_label ?? 'Neutral' }}">{{ $grievance->sentiment_label ?? 'Neutral' }}</span></td>
                    <td style="font-size: 13px; opacity: 0.7;">{{ $grievance->is_anonymous ? 'Anonymous' : ($grievance->user?->name ?? 'User removed') }}</td>
                </tr>
            @empty
                <tr><td colspan="7" style="text-align: center; padding: 30px; opacity: 0.5;">No grievances found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
