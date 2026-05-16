@extends('admin.layout')

@section('title', 'Grievance Details - ' . $grievance->ticket_id)

@section('admin-content')
<div style="margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 30px; font-weight: 900; margin: 0; letter-spacing: -1px;">
            Ticket <span style="color: var(--brand);">{{ $grievance->ticket_id }}</span>
        </h1>
        <p style="opacity: 0.5; margin-top: 8px;">Submitted {{ $grievance->created_at->diffForHumans() }} by {{ $grievance->is_anonymous ? 'Anonymous User' : ($grievance->user?->name ?? 'Deleted User') }}</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Queue</a>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px; margin-bottom: 30px;">
    {{-- Left: Details --}}
    <div style="display: grid; gap: 24px;">
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                <div>
                    <h2 style="margin: 0; font-size: 22px; font-weight: 800;">{{ $grievance->subject }}</h2>
                    <div style="display: flex; gap: 8px; margin-top: 12px; flex-wrap: wrap;">
                        <span class="badge {{ str_replace(' ', '', $grievance->status) }}" style="font-size: 11px;">{{ $grievance->status }}</span>
                        <span class="badge {{ $grievance->priority }}" style="font-size: 11px;">{{ $grievance->priority }}</span>
                        <span class="badge" style="font-size: 11px; opacity: 0.7;">{{ $grievance->category }}</span>
                        @if($grievance->sentiment_label)
                            <span class="badge {{ $grievance->sentiment_label }}" style="font-size: 11px;">{{ $grievance->sentiment_label }}</span>
                        @endif
                    </div>
                </div>
                @if($grievance->isOverdue())
                    <div style="background: rgba(239,68,68,0.1); border: 1px solid #ef4444; border-radius: 12px; padding: 8px 16px; font-size: 12px; font-weight: 800; color: #ef4444; text-transform: uppercase; letter-spacing: 1px;">
                        ⚠ SLA Overdue
                    </div>
                @endif
            </div>

            <div style="padding: 20px; border-radius: 16px; background: rgba(255,107,0,0.03); border: 1px solid var(--border); margin-bottom: 20px; line-height: 1.8; font-size: 14px;">
                {{ $grievance->description }}
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; font-size: 13px;">
                <div style="padding: 12px 16px; border-radius: 12px; background: var(--bg); border: 1px solid var(--border);">
                    <div style="font-size: 10px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">SLA Deadline</div>
                    <div style="font-weight: 700; color: {{ $grievance->isOverdue() ? '#ef4444' : 'var(--text)' }};">{{ $grievance->due_at?->format('M d, Y') ?? 'Not set' }}</div>
                </div>
                <div style="padding: 12px 16px; border-radius: 12px; background: var(--bg); border: 1px solid var(--border);">
                    <div style="font-size: 10px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Assigned To</div>
                    <div style="font-weight: 700;">{{ $grievance->assignee?->name ?? 'Unassigned' }}</div>
                </div>
                <div style="padding: 12px 16px; border-radius: 12px; background: var(--bg); border: 1px solid var(--border);">
                    <div style="font-size: 10px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">AI Category</div>
                    <div style="font-weight: 700;">{{ $grievance->ai_category ?? 'Pending' }}</div>
                </div>
            </div>

            @if($grievance->attachment_path)
            <div style="margin-top: 16px;">
                <a href="{{ asset('storage/' . $grievance->attachment_path) }}" target="_blank" class="btn btn-secondary" style="font-size: 13px;">
                    <svg style="width:16px;height:16px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    View Attachment
                </a>
            </div>
            @endif
        </div>

        {{-- Timeline --}}
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 24px; font-size: 18px; font-weight: 800;">Activity Timeline</h3>
            <div style="display: grid; gap: 0; position: relative;">
                <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: var(--border);"></div>
                @forelse($grievance->updates->sortByDesc('created_at') as $update)
                <div style="display: flex; gap: 16px; padding-bottom: 24px; position: relative;">
                    <div style="width: 32px; height: 32px; background: var(--brand); border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; z-index: 1;">
                        <svg style="width:14px;height:14px;color:#000" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div style="flex: 1; padding-top: 4px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                            <span style="font-weight: 800; font-size: 14px;">{{ $update->user?->name ?? 'System' }}</span>
                            <span style="font-size: 11px; opacity: 0.4;">{{ $update->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        @if($update->status)
                            <span class="badge {{ str_replace(' ', '', $update->status) }}" style="font-size: 10px; margin-bottom: 6px; display: inline-block;">{{ $update->status }}</span>
                        @endif
                        <p style="margin: 0; font-size: 13px; opacity: 0.8; line-height: 1.6;">{{ $update->note }}</p>
                    </div>
                </div>
                @empty
                    <p style="opacity: 0.5; font-size: 13px; padding-left: 50px;">No updates recorded yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right: Controls --}}
    <div style="display: grid; gap: 24px; align-content: start;">
        <div class="card" id="moderation-card">
            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; font-weight: 800;">Moderation Controls</h3>
            <form id="mod-form" method="POST" action="{{ route('admin.grievances.update', $grievance) }}" style="display: grid; gap: 16px;">
                @csrf
                @method('PUT')
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Status</label>
                    <select name="status" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-weight: 600;">
                        @foreach($statuses as $status)
                            <option @selected($grievance->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Assign To</label>
                    <select name="assigned_to" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-weight: 600;">
                        <option value="">Unassigned</option>
                        @foreach($moderators as $mod)
                            <option value="{{ $mod->id }}" @selected($grievance->assigned_to === $mod->id)>{{ $mod->name }} ({{ $mod->role }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Admin Reply</label>
                    <textarea name="admin_reply" placeholder="Share progress or ask for clarification..." rows="4" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); resize: vertical;"></textarea>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Resolution Summary</label>
                    <textarea name="resolution_summary" rows="3" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); resize: vertical;">{{ old('resolution_summary', $grievance->resolution_summary) }}</textarea>
                </div>
                <button id="mod-btn" type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    Save Update
                </button>
                <div id="mod-feedback" style="display: none; padding: 12px; border-radius: 12px; background: rgba(16,185,129,0.1); border: 1px solid #10b981; color: #10b981; text-align: center; font-weight: 700; font-size: 13px;">
                    ✓ Update saved successfully!
                </div>
            </form>
        </div>

        @if($grievance->feedback)
        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 16px; font-size: 16px; font-weight: 800;">Feedback Received</h3>
            <div style="display: flex; gap: 4px; margin-bottom: 8px;">
                @for($i = 1; $i <= 5; $i++)
                    <span style="font-size: 20px; color: {{ $i <= $grievance->feedback->rating ? '#f59e0b' : 'var(--border)' }};">★</span>
                @endfor
            </div>
            <p style="font-size: 13px; opacity: 0.7; line-height: 1.6;">{{ $grievance->feedback->comments ?: 'No written feedback provided.' }}</p>
        </div>
        @endif
    </div>
</div>
@endsection

@section('admin-scripts')
<script>
document.getElementById('mod-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('mod-btn');
    const feedback = document.getElementById('mod-feedback');

    btn.disabled = true;
    btn.innerHTML = '<span style="display:inline-block;width:16px;height:16px;border:2px solid rgba(0,0,0,0.2);border-top-color:#000;border-radius:50%;animation:spin 0.8s linear infinite;margin-right:8px;"></span>Saving...';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        if (response.ok || response.redirected) {
            feedback.style.display = 'block';
            setTimeout(() => window.location.reload(), 1500);
        } else {
            alert('Failed to save update.');
        }
    } catch (err) {
        form.submit(); // Fallback to normal submit
    } finally {
        btn.disabled = false;
        btn.innerHTML = 'Save Update';
    }
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
</style>
@endsection

