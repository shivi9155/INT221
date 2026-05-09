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
            </div>
        </div>
    </section>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:20px;">
            <div>
                <h2 style="margin:0; font-size:22px; font-family:'Space Grotesk', 'Manrope', sans-serif;">All Grievances</h2>
                <p class="subtitle">A live queue of submissions with status, priority, and ownership context.</p>
            </div>
            <div class="badge">{{ $grievances->total() }} total</div>
        </div>

        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>User Details</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grievances as $grievance)
                        <tr>
                            <td>
                                <strong>{{ $grievance->ticket_id }}</strong>
                            </td>
                            <td>
                                @if($grievance->is_anonymous)
                                    <span class="badge">Anonymous</span>
                                @else
                                    <div>
                                        <strong>{{ $grievance->user->name }}</strong><br>
                                        <small style="color: var(--muted);">{{ $grievance->user->email }}</small>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $grievance->subject }}</td>
                            <td>
                                <span class="badge">{{ $grievance->category }}</span>
                            </td>
                            <td>
                                <span class="badge {{ $grievance->priority }}">{{ $grievance->priority }}</span>
                            </td>
                            <td>
                                <span class="badge {{ str_replace(' ', '', $grievance->status) }}">{{ $grievance->status }}</span>
                            </td>
                            <td>
                                {{ $grievance->created_at->format('M d, Y') }}<br>
                                <small style="color: var(--muted);">{{ $grievance->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.grievances.show', $grievance) }}" class="btn secondary" style="padding: 8px 12px; font-size: 12px;">View & Reply</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 40px; color: var(--muted);">
                                No grievances found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $grievances->links() }}
        </div>
    </div>
</div>
@endsection
