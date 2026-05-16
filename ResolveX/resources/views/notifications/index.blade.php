@extends('layouts.app')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 30px;">
    <div>
        <h1 style="font-size: 32px; font-weight: 800; margin: 0;">Notifications</h1>
        <p style="opacity: 0.6; margin-top: 8px;">Stay updated on your startup's grievance lifecycle.</p>
    </div>
    @if($notifications->count() > 0)
        <form method="POST" action="{{ route('notifications.read-all') }}">
            @csrf
            <button type="submit" class="btn btn-secondary">
                <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Mark all as read
            </button>
        </form>
    @endif
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    <div style="display: grid; gap: 0;">
        @forelse ($notifications as $notification)
            <div style="padding: 24px; border-bottom: 1px solid var(--border); display: flex; gap: 20px; transition: background 0.2s; position: relative; {{ ! $notification->read_at ? 'background: rgba(255,107,0,0.02);' : '' }}">
                @if(! $notification->read_at)
                    <div style="position: absolute; left: 0; top: 0; bottom: 0; width: 4px; background: var(--brand);"></div>
                @endif
                
                <div style="width: 48px; height: 48px; border-radius: 12px; background: {{ ! $notification->read_at ? 'rgba(255,107,0,0.1)' : 'var(--bg)' }}; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; color: var(--brand); flex-shrink: 0;">
                    @if(str_contains(strtolower($notification->data['title'] ?? ''), 'status'))
                        <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    @elseif(str_contains(strtolower($notification->data['title'] ?? ''), 'escalat'))
                        <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    @else
                        <svg style="width:24px;height:24px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    @endif
                </div>

                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px;">
                        <h4 style="margin: 0; font-size: 16px; font-weight: 800;">{{ $notification->data['title'] ?? 'System Update' }}</h4>
                        <span style="font-size: 12px; opacity: 0.5; font-weight: 600;">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p style="margin: 0 0 16px; font-size: 14px; opacity: 0.7; line-height: 1.5;">{{ $notification->data['message'] ?? 'New activity has been recorded on your account.' }}</p>
                    
                    @if (! empty($notification->data['grievance_id']))
                        <a href="{{ route('grievances.show', $notification->data['grievance_id']) }}" class="btn btn-secondary" style="font-size: 12px; padding: 6px 12px;">
                            View Ticket
                            <svg style="width:14px;height:14px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div style="padding: 60px; text-align: center;">
                <div style="width: 64px; height: 64px; background: rgba(255,107,0,0.05); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: var(--brand);">
                    <svg style="width:32px;height:32px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 style="margin: 0;">All Clear!</h3>
                <p style="opacity: 0.5; margin-top: 10px;">You have no notifications at the moment.</p>
            </div>
        @endforelse
    </div>
</div>

<div style="margin-top: 24px;">
    {{ $notifications->links() }}
</div>
@endsection
