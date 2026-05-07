@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <h1 class="title">Dashboard</h1>
        <p class="subtitle">SLA, workload, and resolution overview.</p>
    </div>
    <a class="btn" href="{{ route('grievances.create') }}">New grievance</a>
</div>

<section class="grid grid-4">
    <div class="card"><div class="muted">Total tickets</div><div class="stat">{{ $stats['total'] }}</div></div>
    <div class="card"><div class="muted">Pending</div><div class="stat">{{ $stats['pending'] }}</div></div>
    <div class="card"><div class="muted">Resolved</div><div class="stat">{{ $stats['resolved'] }}</div></div>
    <div class="card"><div class="muted">High priority</div><div class="stat">{{ $stats['high'] }}</div></div>
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
    <h2 style="margin-top:0">Recent grievances</h2>
    @include('grievances._table', ['grievances' => $recent])
</section>
@endsection
