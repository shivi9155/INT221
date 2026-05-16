@extends('admin.layout')

@section('title', 'Admin Command Center')

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
    <div>
        <h1 style="font-size: 36px; font-weight: 900; margin: 0; letter-spacing: -1px;">Command <span style="color: var(--brand);">Center</span></h1>
        <p style="opacity: 0.5; margin-top: 10px; font-size: 16px;">Triage, escalate, and resolve grievances across the startup ecosystem.</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.export') }}" class="btn btn-secondary">
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export CSV
        </a>
        <a href="{{ route('admin.analytics') }}" class="btn btn-secondary">
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            System Analytics
        </a>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            User Access
        </a>
    </div>
</div>


<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Total Queue</div>
        <div style="font-size: 28px; font-weight: 900;">{{ $stats['total'] }}</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Resolved Cases</div>
        <div style="font-size: 28px; font-weight: 900; color: #10b981;">{{ $stats['resolved'] }}</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Escalations</div>
        <div style="font-size: 28px; font-weight: 900; color: #ef4444;">{{ $stats['escalated'] }}</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Overdue SLA</div>
        <div style="font-size: 28px; font-weight: 900; color: #f59e0b;">{{ $stats['overdue'] }}</div>
    </div>
</div>

<div class="card" style="margin-bottom: 30px; border-radius: 24px; background: rgba(255,107,0,0.02);">
    <form method="GET" style="display: grid; grid-template-columns: 2fr 1fr 1fr 1fr auto; gap: 16px; align-items: center; padding: 5px;">
        <div style="position: relative;">
            <svg style="position: absolute; left: 16px; top: 12px; width: 18px; height: 18px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input name="search" value="{{ request('search') }}" placeholder="Search ID, subject, keywords..." style="width: 100%; padding: 10px 10px 10px 46px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
        </div>
        <select name="status" style="padding: 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 13px; font-weight: 600;">
            <option value="">Status</option>
            @foreach($statuses as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach
        </select>
        <select name="category" style="padding: 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 13px; font-weight: 600;">
            <option value="">Category</option>
            @foreach($categories as $category)<option @selected(request('category')===$category)>{{ $category }}</option>@endforeach
        </select>
        <select name="priority" style="padding: 10px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 13px; font-weight: 600;">
            <option value="">Priority</option>
            @foreach($priorities as $priority)<option @selected(request('priority')===$priority)>{{ $priority }}</option>@endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
    </form>
</div>

<div class="card" style="padding: 0; overflow: hidden; border-radius: 24px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(255,107,0,0.05); border-bottom: 1px solid var(--border);">
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Ticket & User</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Grievance Details</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Status</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">SLA Context</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grievances as $g)
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,107,0,0.01)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px;">
                            <div style="font-weight: 900; font-size: 14px; color: var(--brand); letter-spacing: 1px;">{{ $g->ticket_id }}</div>
                            <div style="font-size: 12px; opacity: 0.6; margin-top: 4px;">{{ $g->is_anonymous ? 'Anonymous User' : ($g->user?->name ?? 'Deleted User') }}</div>
                        </td>
                        <td style="padding: 20px;">
                            <div style="font-weight: 700; font-size: 14px; margin-bottom: 4px;">{{ Str::limit($g->subject, 40) }}</div>
                            <span class="badge" style="font-size: 10px; opacity: 0.7;">{{ $g->category }}</span>
                            <span class="badge {{ $g->priority }}" style="font-size: 9px; margin-left: 4px;">{{ $g->priority }}</span>
                        </td>
                        <td style="padding: 20px;">
                            <span class="badge {{ str_replace(' ', '', $g->status) }}" style="font-size: 11px;">{{ $g->status }}</span>
                            @if($g->escalated_at)
                                <div style="font-size: 10px; color: #ef4444; font-weight: 800; margin-top: 4px; text-transform: uppercase;">Escalated</div>
                            @endif
                        </td>
                        <td style="padding: 20px;">
                            <div style="font-size: 13px; font-weight: 700; color: {{ $g->isOverdue() ? '#ef4444' : 'var(--text)' }};">
                                {{ $g->due_at?->diffForHumans() ?? 'No Deadline' }}
                            </div>
                            <div style="font-size: 11px; opacity: 0.5; margin-top: 2px;">{{ $g->created_at->format('M d, Y') }}</div>
                        </td>
                        <td style="padding: 20px;">
                            <a href="{{ route('admin.grievances.show', $g) }}" class="btn btn-secondary" style="font-size: 11px; padding: 8px 12px;">Manage</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 30px;">
    {{ $grievances->links() }}
</div>
@endsection
