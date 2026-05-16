@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <div>
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
            <h1 style="font-size: 32px; font-weight: 800; margin: 0;">{{ $grievance->ticket_id }}</h1>
            <span class="badge {{ $grievance->priority }}" style="padding: 6px 12px; font-size: 11px;">{{ $grievance->priority }} Priority</span>
        </div>
        <p style="opacity: 0.6; margin: 0;">{{ $grievance->subject }}</p>
    </div>
    <a href="{{ route('grievances.index') }}" class="btn btn-secondary">
        <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Queue
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 30px;">
    <!-- Left Column: Details -->
    <div style="display: grid; gap: 30px;">
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <svg style="width:20px;height:20px;color:var(--brand)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Information
            </h3>
            
            <div style="display: grid; gap: 16px;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                    <span style="opacity: 0.5; font-size: 14px;">Status</span>
                    <span style="font-weight: 700; color: var(--brand);">{{ $grievance->status }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                    <span style="opacity: 0.5; font-size: 14px;">Category</span>
                    <span style="font-weight: 700;">{{ $grievance->category }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                    <span style="opacity: 0.5; font-size: 14px;">Submitted By</span>
                    <span style="font-weight: 700;">{{ $grievance->is_anonymous ? 'Anonymous' : ($grievance->user?->name ?? 'User removed') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                    <span style="opacity: 0.5; font-size: 14px;">Sentiment</span>
                    <span class="badge {{ $grievance->sentiment_label ?? 'Neutral' }}">{{ $grievance->sentiment_label ?? 'Neutral' }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                    <span style="opacity: 0.5; font-size: 14px;">SLA Deadline</span>
                    <span style="font-weight: 700;">{{ $grievance->due_at?->format('d M Y') ?? 'N/A' }}</span>
                </div>
            </div>

            <div style="margin-top: 30px;">
                <h4 style="margin-bottom: 12px; font-size: 14px; opacity: 0.5;">Description</h4>
                <div style="padding: 20px; border-radius: 16px; background: rgba(255,107,0,0.03); border: 1px solid var(--border); line-height: 1.6;">
                    {{ $grievance->description }}
                </div>
            </div>

            @if ($grievance->attachment_path)
                <div style="margin-top: 20px;">
                    <a href="{{ asset('storage/'.$grievance->attachment_path) }}" target="_blank" class="btn btn-secondary" style="width: 100%;">
                        <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13"></path></svg>
                        View Attachment
                    </a>
                </div>
            @endif
        </div>

        @if (auth()->user()->isStaff())
            <div class="card">
                <h3 style="margin-top: 0; margin-bottom: 20px;">Resolution Control</h3>
                <form method="POST" action="{{ route('grievances.update', $grievance) }}" style="display: grid; gap: 16px;">
                    @csrf
                    @method('PUT')
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Update Status</label>
                        <select name="status" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                            @foreach($statuses as $status)
                                <option @selected($grievance->status===$status)>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Resolution Note</label>
                        <textarea name="resolution_summary" placeholder="Summary of the resolution..." style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); min-height: 100px;">{{ old('resolution_summary', $grievance->resolution_summary) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">Update Ticket</button>
                </form>
            </div>
        @endif
    </div>

    <!-- Right Column: Activity & Comments -->
    <div style="display: grid; gap: 30px;">
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 30px; display: flex; align-items: center; gap: 10px;">
                <svg style="width:20px;height:20px;color:var(--brand)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Activity Timeline
            </h3>

            <div style="display: grid; gap: 24px; position: relative;">
                <div style="position: absolute; left: 20px; top: 0; bottom: 0; width: 2px; background: var(--border);"></div>
                
                @forelse ($grievance->updates as $update)
                    <div style="position: relative; padding-left: 50px;">
                        <div style="position: absolute; left: 12px; top: 0; width: 18px; height: 18px; border-radius: 50%; background: var(--brand); border: 4px solid var(--card-bg);"></div>
                        <div style="background: rgba(255,107,0,0.03); border: 1px solid var(--border); padding: 16px; border-radius: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-weight: 800; font-size: 14px; color: var(--brand);">{{ $update->status ?? 'Comment' }}</span>
                                <span style="font-size: 12px; opacity: 0.5;">{{ $update->created_at->diffForHumans() }}</span>
                            </div>
                            <p style="margin: 0; font-size: 14px; line-height: 1.5;">{{ $update->note }}</p>
                            <div style="margin-top: 8px; font-size: 12px; opacity: 0.6; font-weight: 700;">— {{ $update->user?->name ?? 'System' }}</div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; opacity: 0.5; padding: 20px;">No activity yet.</p>
                @endforelse
            </div>

            <div style="margin-top: 40px; border-top: 1px solid var(--border); pt: 30px;">
                <h4 style="margin-bottom: 16px;">Add Comment</h4>
                <form method="POST" action="{{ route('grievances.comments.store', $grievance) }}" style="display: grid; gap: 16px;">
                    @csrf
                    <textarea name="note" placeholder="Write your message..." required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); min-height: 80px;"></textarea>
                    <button type="submit" class="btn btn-secondary" style="justify-content: center;">Post Activity</button>
                </form>
            </div>
        </div>

        @if ($grievance->status === 'Resolved' && $grievance->user_id === auth()->id() && !$grievance->feedback)
            <div class="card" style="border: 1px solid var(--brand);">
                <h3 style="margin-top: 0; color: var(--brand);">Rate Resolution</h3>
                <form method="POST" action="{{ route('feedback.store', $grievance) }}" style="display: grid; gap: 16px;">
                    @csrf
                    <div style="display: flex; gap: 20px; align-items: center;">
                        <label style="font-weight: 700;">How satisfied are you?</label>
                        <select name="rating" style="padding: 8px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                            @for($i=5; $i>=1; $i--)<option value="{{ $i }}">{{ $i }} Stars</option>@endfor
                        </select>
                    </div>
                    <textarea name="comments" placeholder="Any feedback for us?" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); min-height: 80px;"></textarea>
                    <button type="submit" class="btn btn-primary" style="justify-content: center;">Submit Feedback</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
