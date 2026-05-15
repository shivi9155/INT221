@extends('admin.layout')

@section('title', 'User Management')

@section('admin-content')
<div class="stack">
    <section class="hero-panel">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap; position:relative; z-index:1;">
            <div>
                <div style="text-transform:uppercase; letter-spacing:0.12em; font-size:12px; font-weight:800; opacity:0.8;">Identity and access</div>
                <h2 style="margin:10px 0 8px; font-size:32px; font-family:'Space Grotesk', 'Manrope', sans-serif;">Manage founders, employees, and staff access</h2>
                <p class="subtitle" style="max-width:640px;">Adjust roles, deactivate accounts, and keep moderation ownership clear across the platform.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn secondary">Back to admin</a>
        </div>
    </section>

    <section class="grid grid-4">
        <div class="card"><div class="muted">Total users</div><div class="stat">{{ $stats['total_users'] }}</div></div>
        <div class="card"><div class="muted">Admins</div><div class="stat">{{ $stats['admin_count'] }}</div></div>
        <div class="card"><div class="muted">Moderators</div><div class="stat">{{ $stats['moderator_count'] }}</div></div>
        <div class="card"><div class="muted">Regular users</div><div class="stat">{{ $stats['user_count'] }}</div></div>
    </section>

    <form method="GET" class="card filters">
        <div>
            <label>Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, startup">
        </div>
        <div>
            <label>Role</label>
            <select name="role">
                <option value="">All roles</option>
                <option value="admin" @selected(request('role') === 'admin')>Admin</option>
                <option value="moderator" @selected(request('role') === 'moderator')>Moderator</option>
                <option value="user" @selected(request('role') === 'user')>User</option>
            </select>
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="">All</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
        </div>
        <button class="btn" type="submit">Apply</button>
    </form>

    <section class="card">
        <div style="overflow:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Startup role</th>
                        <th>Platform role</th>
                        <th>Status</th>
                        <th>Grievances</th>
                        <th>Notifications</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong><br>
                                <small class="muted">{{ $user->email }}</small><br>
                                <small class="muted">{{ $user->startup_name ?: 'No startup listed' }}</small>
                            </td>
                            <td>{{ ucfirst($user->user_type) }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.update-role', $user) }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" onchange="this.form.submit()">
                                        <option value="user" @selected($user->role === 'user')>User</option>
                                        <option value="moderator" @selected($user->role === 'moderator')>Moderator</option>
                                        <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    </select>
                                </form>
                            </td>
                            <td><span class="badge {{ $user->is_active ? 'Resolved' : 'High' }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td>{{ $user->grievances_count }}</td>
                            <td>
                                <div class="muted" style="font-size:12px;">Email: {{ $user->wants_email_notifications ? 'On' : 'Off' }}</div>
                                <div class="muted" style="font-size:12px;">In-app: {{ $user->wants_in_app_notifications ? 'On' : 'Off' }}</div>
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.status', $user) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn secondary" type="submit">{{ $user->is_active ? 'Deactivate' : 'Reactivate' }}</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="muted">No users found for the current filter.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px;">
            {{ $users->links() }}
        </div>
    </section>
</div>
@endsection
