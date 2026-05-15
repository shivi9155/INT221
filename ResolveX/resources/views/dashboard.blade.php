@extends('layouts.app')

@section('content')
<section class="hero-panel" style="margin-bottom:18px;">
    <div class="top" style="margin-bottom:0; position:relative; z-index:1;">
        <div>
            <div class="soft-note" style="background:rgba(255,255,255,0.12); color:#eef8ff;">Operations snapshot</div>
            <h1 class="title" style="color:#f4fbff; margin-top:16px;">Dashboard</h1>
            <p class="subtitle">SLA, workload, and resolution overview for the cases you can influence right now.</p>
        </div>
        <a class="btn" href="{{ route('grievances.create') }}" style="background:linear-gradient(135deg, #ee6c4d, #c95a3e); border-color:#ee6c4d;">New grievance</a>
    </div>
</section>

<section class="grid grid-4">
    <div class="card"><div class="muted">Total tickets</div><div class="stat">{{ $stats['total'] }}</div><div class="subtitle">All visible grievances in your current scope.</div></div>
    <div class="card"><div class="muted">Pending</div><div class="stat">{{ $stats['pending'] }}</div><div class="subtitle">Open issues waiting for action or closure.</div></div>
    <div class="card"><div class="muted">Resolved</div><div class="stat">{{ $stats['resolved'] }}</div><div class="subtitle">Successfully closed tickets so far.</div></div>
    <div class="card"><div class="muted">High priority</div><div class="stat">{{ $stats['high'] }}</div><div class="subtitle">Cases that need faster intervention.</div></div>
</section>

<section class="grid grid-2" style="margin-top:16px">
    <div class="card">
        <h2 style="margin-top:0">SLA watch</h2>
        <div class="grid grid-2">
            <div>
                <div class="muted">Escalated</div>
                <div class="stat" style="font-size:30px;">{{ $stats['escalated'] }}</div>
            </div>
            <div>
                <div class="muted">Overdue</div>
                <div class="stat" style="font-size:30px;">{{ $stats['overdue'] }}</div>
            </div>
        </div>
        <p class="subtitle">Cases can auto-escalate when urgency is high or the SLA deadline is missed.</p>
    </div>
    <div class="card">
        <h2 style="margin-top:0">Recent notifications</h2>
        <div class="timeline">
            @forelse ($notifications as $notification)
                <div class="event">
                    <strong>{{ $notification->data['title'] ?? 'Update' }}</strong>
                    <div class="muted">{{ $notification->created_at->diffForHumans() }}</div>
                    <p>{{ $notification->data['message'] ?? 'New activity available.' }}</p>
                </div>
            @empty
                <p class="muted">No notifications yet.</p>
            @endforelse
        </div>
        <div style="margin-top:16px;">
            <a class="btn secondary" href="{{ route('notifications.index') }}">Open all notifications</a>
        </div>
    </div>
</section>

<section class="grid grid-2" style="margin-top:16px">
    <div class="card">
        <h2 style="margin-top:0">Monthly complaints</h2>
        <div class="grid">
            @forelse ($monthly as $month => $total)
                <div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px"><span>{{ $month }}</span><strong>{{ $total }}</strong></div>
                    <div class="bar"><span style="width:{{ min(100, $total * 20) }}%"></span></div>
                </div>
            @empty
                <p class="muted">No complaint data yet.</p>
            @endforelse
        </div>
    </div>
    <div class="card">
        <h2 style="margin-top:0">Resolved rate</h2>
        @php $rate = $stats['total'] ? round(($stats['resolved'] / $stats['total']) * 100) : 0; @endphp
        <div class="stat">{{ $rate }}%</div>
        <div class="bar"><span style="width:{{ $rate }}%"></span></div>
        <p class="subtitle">Resolution progress across visible tickets.</p>
    </div>
</section>

<section class="card" style="margin-top:16px">
    <div class="top" style="margin-bottom:14px;">
        <div>
            <h2 style="margin:0">Recent grievances</h2>
            <p class="subtitle">A quick read on what just entered the system.</p>
        </div>
        <a class="btn secondary" href="{{ route('grievances.index') }}">View all tickets</a>
    </div>
    @include('grievances._table', ['grievances' => $recent])
</section>
@endsection
