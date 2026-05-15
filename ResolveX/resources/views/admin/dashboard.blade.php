@extends('admin.layout')

@section('title', 'Grievance Dashboard')

@section('admin-content')
<div class="stack">
    <section class="hero-panel">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap; position:relative; z-index:1;">
            <div>
                <div style="text-transform:uppercase; letter-spacing:0.12em; font-size:12px; font-weight:800; opacity:0.8;">Admin control room</div>
                <h2 style="margin:10px 0 8px; font-size:32px; font-family:'Space Grotesk', 'Manrope', sans-serif;">Stay ahead of every grievance</h2>
                <p class="subtitle" style="max-width:640px;">Track the latest submissions, move critical issues faster, and keep response quality consistent across the board.</p>
            </div>
            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="{{ route('admin.analytics') }}" class="btn" style="background:linear-gradient(135deg, #ee6c4d, #c95a3e); border-color:#ee6c4d;">Open Analytics</a>
                <a href="{{ route('admin.users') }}" class="btn secondary">Manage Users</a>
            </div>
        </div>
    </section>

    <section class="grid grid-4">
        <div class="card"><div class="muted">Total tickets</div><div class="stat">{{ $stats['total'] }}</div></div>
        <div class="card"><div class="muted">Resolved</div><div class="stat">{{ $stats['resolved'] }}</div></div>
        <div class="card"><div class="muted">Escalated</div><div class="stat">{{ $stats['escalated'] }}</div></div>
        <div class="card"><div class="muted">Overdue</div><div class="stat">{{ $stats['overdue'] }}</div></div>
    </section>

    <form method="GET" class="card filters">
        <div>
            <label>Search</label>
            <input name="search" value="{{ request('search') }}" placeholder="Ticket ID, subject, keyword">
        </div>
        <div>
            <label>Status</label>
            <select name="status"><option value="">All</option>@foreach($statuses as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select>
        </div>
        <div>
            <label>Category</label>
            <select name="category"><option value="">All</option>@foreach($categories as $category)<option @selected(request('category')===$category)>{{ $category }}</option>@endforeach</select>
        </div>
        <div>
            <label>Priority</label>
            <select name="priority"><option value="">All</option>@foreach($priorities as $priority)<option @selected(request('priority')===$priority)>{{ $priority }}</option>@endforeach</select>
        </div>
        <div>
            <label>From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}">
        </div>
        <div>
            <label>To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}">
        </div>
        <button class="btn" type="submit">Filter</button>
    </form>

    <section class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
            <div>
                <h2 style="margin:0; font-size:22px; font-family:'Space Grotesk', 'Manrope', sans-serif;">All Grievances</h2>
                <p class="subtitle">A live queue of submissions with status, priority, SLA, and ownership context.</p>
            </div>
            <div class="badge">{{ $grievances->total() }} total</div>
        </div>

        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>User Details</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>SLA</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grievances as $grievance)
                        <tr>
                            <td><strong>{{ $grievance->ticket_id }}</strong></td>
                            <td>
                                @if($grievance->is_anonymous)
                                    <span class="badge">Anonymous</span>
                                @else
                                    <div>
                                        <strong>{{ $grievance->user?->name ?? 'User removed' }}</strong><br>
                                        <small style="color: var(--muted);">{{ $grievance->user?->email ?? 'No email' }}</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $grievance->subject }}</td>
                            <td><span class="badge">{{ $grievance->category }}</span></td>
                            <td><span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span></td>
                            <td>
                                <span class="badge {{ str_replace(' ', '', $grievance->status) }}">{{ $grievance->status }}</span>
                                @if($grievance->escalated_at)
                                    <div class="muted" style="font-size:12px;">Escalated</div>
                                @endif
                            </td>
                            <td>
                                {{ $grievance->due_at?->format('M d, H:i') ?? 'N/A' }}<br>
                                <small style="color: var(--muted);">{{ $grievance->isOverdue() ? 'Overdue' : 'Within SLA' }}</small>
                            </td>
                            <td>
                                {{ $grievance->created_at->format('M d, Y') }}<br>
                                <small style="color: var(--muted);">{{ $grievance->created_at->diffForHumans() }}</small>
                            </td>
                            <td><a href="{{ route('admin.grievances.show', $grievance) }}" class="btn secondary" style="padding:8px 12px; font-size:12px;">View & Reply</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align:center; padding:40px; color:var(--muted);">No grievances found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px;">
            {{ $grievances->links() }}
        </div>
    </section>
</div>
@endsection
