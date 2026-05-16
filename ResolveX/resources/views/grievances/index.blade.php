@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
    <div>
        <h1 style="font-size: 36px; font-weight: 900; margin: 0; letter-spacing: -1px;">Ticket <span style="color: var(--brand);">Intelligence</span></h1>
        <p style="opacity: 0.5; margin-top: 10px; font-size: 16px;">Advanced triage and lifecycle tracking for every startup grievance.</p>
    </div>
    <a href="{{ route('grievances.create') }}" class="btn btn-primary" style="padding: 14px 28px; box-shadow: 0 10px 30px rgba(255,107,0,0.3);">
        <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        New Ticket
    </a>
</div>

<div class="card" style="margin-bottom: 40px; border-radius: 30px; background: rgba(255,107,0,0.02); border: 1px solid var(--border);">
    <form method="GET" style="display: flex; flex-wrap: wrap; gap: 16px; align-items: center; padding: 10px;">
        <div style="flex: 1; min-width: 250px; position: relative;">
            <svg style="position: absolute; left: 16px; top: 14px; width: 18px; height: 18px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input name="search" value="{{ request('search') }}" placeholder="Search ID, subject, or keywords..." style="width: 100%; padding: 12px 12px 12px 46px; border-radius: 16px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
        </div>
        
        <div style="display: flex; gap: 10px;">
            <select name="status" style="padding: 12px 16px; border-radius: 16px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-weight: 600;">
                <option value="">All Status</option>
                @foreach($statuses as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach
            </select>
            <select name="priority" style="padding: 12px 16px; border-radius: 16px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-weight: 600;">
                <option value="">All Priority</option>
                @foreach($priorities as $priority)<option @selected(request('priority')===$priority)>{{ $priority }}</option>@endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-secondary" style="border-radius: 16px; height: 48px; padding: 0 24px;">Apply Filters</button>
    </form>
</div>

<div style="display: grid; gap: 20px;">
    @forelse ($grievances as $item)
        <a href="{{ route('grievances.show', $item) }}" style="text-decoration: none; color: inherit; display: block;">
            <div class="card" style="padding: 24px; border-radius: 24px; display: grid; grid-template-columns: 4px 1fr auto; gap: 24px; align-items: center; transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateX(10px)'; this.style.borderColor='var(--brand)'" onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='var(--border)'">
                <!-- Sentiment Indicator -->
                <div style="height: 100%; width: 100%; background: {{ 
                    $item->sentiment_label === 'Critical' ? '#ef4444' : 
                    ($item->sentiment_label === 'Concerned' ? '#f59e0b' : 
                    ($item->sentiment_label === 'Calm' ? '#10b981' : 'var(--border)')) 
                }}; border-radius: 2px;"></div>
                
                <div>
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <span style="font-size: 11px; font-weight: 900; opacity: 0.4; letter-spacing: 1px;">{{ $item->ticket_id }}</span>
                        <span class="badge {{ $item->priority }}" style="font-size: 9px; padding: 4px 8px;">{{ $item->priority }}</span>
                    </div>
                    <h3 style="margin: 0; font-size: 18px; font-weight: 800; color: var(--text);">{{ $item->subject }}</h3>
                    <div style="display: flex; gap: 16px; margin-top: 10px; font-size: 13px; opacity: 0.5;">
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            {{ $item->category }}
                        </span>
                        <span style="display: flex; align-items: center; gap: 6px;">
                            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $item->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <div style="text-align: right;">
                    <div style="margin-bottom: 8px;">
                        <span class="badge {{ $item->status }}" style="padding: 8px 16px; font-size: 11px; border-radius: 99px; {{ $item->status === 'Resolved' ? 'background: rgba(16,185,129,0.1); color: #10b981;' : '' }}">
                            {{ $item->status }}
                        </span>
                    </div>
                    @if($item->sentiment_label)
                        <div style="font-size: 11px; font-weight: 700; opacity: 0.6;">{{ $item->sentiment_label }} Pulse</div>
                    @endif
                </div>
            </div>
        </a>
    @empty
        <div class="card" style="text-align: center; padding: 60px;">
            <p style="opacity: 0.5;">No tickets matching your filters.</p>
        </div>
    @endforelse
</div>

<div style="margin-top: 40px;">
    {{ $grievances->links() }}
</div>
@endsection
