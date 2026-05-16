@extends('layouts.app')

@section('content')
<div style="margin-bottom: 40px;">
    <h1 style="font-size: 36px; font-weight: 900; margin: 0; letter-spacing: -1px; background: linear-gradient(to right, #fff, rgba(255,255,255,0.4)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Workspace <span style="-webkit-text-fill-color: var(--brand);">Intelligence</span></h1>
    <p style="opacity: 0.5; margin-top: 10px; font-size: 16px;">Real-time oversight of startup operations and grievance health.</p>
</div>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
    <!-- Stat 1 -->
    <div class="card" style="position: relative; overflow: hidden; border: 1px solid rgba(255,107,0,0.2);">
        <div style="position: absolute; top: -20px; right: -20px; width: 80px; height: 80px; background: var(--brand); filter: blur(40px); opacity: 0.1;"></div>
        <div style="font-size: 12px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Active Pipeline</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 32px; font-weight: 900; color: var(--brand);">{{ $stats['pending'] }}</span>
            <span style="font-size: 12px; font-weight: 700; color: #ef4444;">Tickets</span>
        </div>
        <div style="margin-top: 15px; height: 4px; background: var(--border); border-radius: 2px; overflow: hidden;">
            <div style="width: {{ ($stats['total'] > 0 ? ($stats['pending'] / $stats['total']) * 100 : 0) }}%; height: 100%; background: var(--brand);"></div>
        </div>
    </div>
    <!-- Stat 2 -->
    <div class="card">
        <div style="font-size: 12px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Resolution Rate</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 32px; font-weight: 900; color: #10b981;">{{ $stats['total'] > 0 ? round(($stats['resolved'] / $stats['total']) * 100) : 0 }}%</span>
            <span style="font-size: 12px; font-weight: 700; opacity: 0.6;">Efficiency</span>
        </div>
        <div style="margin-top: 15px; height: 4px; background: var(--border); border-radius: 2px; overflow: hidden;">
            <div style="width: {{ ($stats['total'] > 0 ? ($stats['resolved'] / $stats['total']) * 100 : 0) }}%; height: 100%; background: #10b981;"></div>
        </div>
    </div>
    <!-- Stat 3 -->
    <div class="card">
        <div style="font-size: 12px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">Critical Pulse</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 32px; font-weight: 900; color: #ef4444;">{{ $stats['high'] }}</span>
            <span style="font-size: 12px; font-weight: 700; opacity: 0.6;">Priority</span>
        </div>
        <div style="margin-top: 15px; display: flex; gap: 4px;">
            @for($i=0; $i<8; $i++)
                <div style="flex:1; height: 4px; border-radius: 2px; background: {{ $i < ($stats['high'] * 2) ? '#ef4444' : 'var(--border)' }}"></div>
            @endfor
        </div>
    </div>
    <!-- Stat 4 -->
    <div class="card">
        <div style="font-size: 12px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">System SLA</div>
        <div style="display: flex; align-items: baseline; gap: 10px;">
            <span style="font-size: 32px; font-weight: 900;">{{ $stats['overdue'] }}</span>
            <span style="font-size: 12px; font-weight: 700; color: #f59e0b;">Overdue</span>
        </div>
        <div style="margin-top: 15px; font-size: 11px; opacity: 0.5;">Targeting 98% resolution in 48h.</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 30px;">
    <!-- Main Activity Bento -->
    <div style="display: grid; gap: 30px;">
        <div class="card" style="background: linear-gradient(135deg, var(--card-bg), rgba(255,107,0,0.02));">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <h3 style="margin: 0; font-size: 20px; font-weight: 800;">Recent Stream</h3>
                <a href="{{ route('grievances.index') }}" class="btn btn-secondary" style="font-size: 12px; padding: 6px 14px;">View Full Queue</a>
            </div>
            
            <div style="display: grid; gap: 16px;">
                @forelse ($recent as $item)
                    <a href="{{ route('grievances.show', $item) }}" style="text-decoration: none; color: inherit;">
                        <div style="display: grid; grid-template-columns: 80px 1fr 120px; align-items: center; padding: 16px; border-radius: 16px; background: var(--bg); border: 1px solid var(--border); transition: all 0.2s; cursor: pointer;" onmouseover="this.style.transform='scale(1.01)'; this.style.borderColor='var(--brand)'" onmouseout="this.style.transform='scale(1)'; this.style.borderColor='var(--border)'">
                            <div style="font-size: 11px; font-weight: 800; opacity: 0.5;">{{ $item->ticket_id }}</div>
                            <div>
                                <div style="font-weight: 700; font-size: 14px;">{{ $item->subject }}</div>
                                <div style="font-size: 12px; opacity: 0.4; margin-top: 2px;">{{ $item->category }} • {{ $item->created_at->diffForHumans() }}</div>
                            </div>
                            <div style="text-align: right;">
                                <span class="badge {{ str_replace(' ', '', $item->status) }}" style="font-size: 10px;">{{ $item->status }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="text-align: center; padding: 40px; opacity: 0.4;">
                        <svg style="width:40px;height:40px;margin:0 auto 12px;display:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <p style="font-size: 14px;">No grievances yet. File your first ticket!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Right Side Sidebar -->
    <div style="display: grid; gap: 30px;">
        <div class="card" style="background: var(--sidebar-bg); border: none;">
            <h3 style="color: white; margin-top: 0; margin-bottom: 20px; font-size: 18px;">Quick Actions</h3>
            <div style="display: grid; gap: 12px;">
                <a href="{{ route('grievances.create') }}" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 16px;">
                    <svg style="width:20px;height:20px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    File New Grievance
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="btn" style="width: 100%; justify-content: center; background: rgba(255,107,0,0.15); border: 1px solid rgba(255,107,0,0.3); color: var(--brand); padding: 14px;">
                    <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Command Center
                </a>
                <a href="{{ route('admin.analytics') }}" class="btn" style="width: 100%; justify-content: center; background: transparent; border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.7); padding: 14px;">
                    <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    System Analytics
                </a>
                @else
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary" style="width: 100%; justify-content: center; border-color: rgba(255,255,255,0.1); color: white;">
                    Manage Profile
                </a>
                @endif
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0; margin-bottom: 20px;">Live Pulse</h3>
            <div style="display: grid; gap: 12px;">
                @forelse ($notifications as $n)
                    <div style="display: flex; gap: 12px; padding-bottom: 12px; border-bottom: 1px solid var(--border);">
                        <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--brand); margin-top: 5px; flex-shrink: 0;"></div>
                        <div>
                            <div style="font-weight: 700; font-size: 13px;">{{ $n->data['title'] ?? 'Update' }}</div>
                            <div style="font-size: 12px; opacity: 0.5;">{{ $n->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; opacity: 0.5;">No live activity.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
