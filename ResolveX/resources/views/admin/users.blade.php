@extends('admin.layout')

@section('title', 'Identity & Access')

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
    <div>
        <h1 style="font-size: 36px; font-weight: 900; margin: 0; letter-spacing: -1px;">Identity <span style="color: var(--brand);">Access</span></h1>
        <p style="opacity: 0.5; margin-top: 10px; font-size: 16px;">Manage startup founders, employees, and administrative oversight.</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <div class="card" style="padding: 10px 20px; border-radius: 16px; display: flex; align-items: center; gap: 10px;">
            <div style="width: 8px; height: 8px; border-radius: 50%; background: #10b981;"></div>
            <span style="font-size: 13px; font-weight: 700;">{{ $stats['total_users'] }} Total Active</span>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px;">
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Admins</div>
        <div style="font-size: 28px; font-weight: 900;">{{ $stats['admin_count'] }}</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Moderators</div>
        <div style="font-size: 28px; font-weight: 900;">{{ $stats['moderator_count'] }}</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Startups</div>
        <div style="font-size: 28px; font-weight: 900;">{{ $stats['user_count'] }}</div>
    </div>
</div>

<div class="card" style="margin-bottom: 30px; border-radius: 24px; background: rgba(255,107,0,0.02);">
    <form method="GET" style="display: flex; gap: 16px; align-items: center; padding: 5px;">
        <div style="flex: 1; position: relative;">
            <svg style="position: absolute; left: 16px; top: 12px; width: 18px; height: 18px; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input name="search" value="{{ request('search') }}" placeholder="Search by name, email or startup..." style="width: 100%; padding: 10px 10px 10px 46px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
        </div>
        <select name="role" style="padding: 10px 16px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-weight: 600;">
            <option value="">All Roles</option>
            <option value="admin" @selected(request('role') === 'admin')>Admin</option>
            <option value="moderator" @selected(request('role') === 'moderator')>Moderator</option>
            <option value="user" @selected(request('role') === 'user')>User</option>
        </select>
        <button type="submit" class="btn btn-secondary">Apply</button>
    </form>
</div>

<div class="card" style="padding: 0; overflow: hidden; border-radius: 24px;">
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: rgba(255,107,0,0.05); border-bottom: 1px solid var(--border);">
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">User Identity</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Startup Context</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Platform Role</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Access</th>
                    <th style="padding: 20px; font-size: 12px; font-weight: 800; opacity: 0.5; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='rgba(255,107,0,0.01)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 20px;">
                            <div style="font-weight: 800; font-size: 15px;">{{ $user->name }}</div>
                            <div style="font-size: 12px; opacity: 0.5; margin-top: 2px;">{{ $user->email }}</div>
                        </td>
                        <td style="padding: 20px;">
                            <div style="font-weight: 700; font-size: 13px;">{{ $user->startup_name ?: 'Independent' }}</div>
                            <div style="font-size: 11px; opacity: 0.5;">{{ ucfirst($user->user_type) }}</div>
                        </td>
                        <td style="padding: 20px;">
                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}">
                                @csrf
                                @method('PUT')
                                <select name="role" onchange="this.form.submit()" style="padding: 6px 12px; border-radius: 8px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 12px; font-weight: 700;">
                                    <option value="user" @selected($user->role === 'user')>User</option>
                                    <option value="moderator" @selected($user->role === 'moderator')>Moderator</option>
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                </select>
                            </form>
                        </td>
                        <td style="padding: 20px;">
                            <span class="badge {{ $user->is_active ? 'Resolved' : 'High' }}" style="font-size: 10px;">
                                {{ $user->is_active ? 'Active' : 'Revoked' }}
                            </span>
                        </td>
                        <td style="padding: 20px;">
                            <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-secondary" style="font-size: 11px; padding: 6px 12px; border-radius: 8px;">
                                    {{ $user->is_active ? 'Revoke Access' : 'Restore Access' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div style="margin-top: 30px;">
    {{ $users->links() }}
</div>
@endsection
