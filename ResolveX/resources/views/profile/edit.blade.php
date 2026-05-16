@extends('layouts.app')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 32px; font-weight: 800; margin: 0;">Account Settings</h1>
    <p style="opacity: 0.6; margin-top: 8px;">Manage your personal information and notification preferences.</p>
</div>

<div style="display: grid; grid-template-columns: 300px 1fr; gap: 30px;">
    <!-- Profile Sidebar -->
    <div style="display: grid; gap: 30px;">
        <div class="card" style="text-align: center;">
            <div style="width: 100px; height: 100px; background: var(--brand); border-radius: 50%; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; font-size: 40px; font-weight: 800; color: #000;">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h3 style="margin: 0;">{{ $user->name }}</h3>
            <p style="opacity: 0.5; font-size: 14px; margin-top: 5px;">{{ ucfirst($user->user_type) }} @ {{ $user->startup_name ?? 'Startup' }}</p>
            
            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border); display: grid; gap: 10px;">
                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                    <span style="opacity: 0.5;">System Role</span>
                    <span style="font-weight: 700;">{{ ucfirst($user->role) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 13px;">
                    <span style="opacity: 0.5;">Status</span>
                    <span style="font-weight: 700; color: #10b981;">Active</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <div class="card">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 40px;">
                <h4 style="margin-top: 0; margin-bottom: 20px; color: var(--brand); text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Personal Information</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Full Name</label>
                        <input name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Email (Locked)</label>
                        <input value="{{ $user->email }}" disabled style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: rgba(0,0,0,0.05); color: var(--text); opacity: 0.5;">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Startup Name</label>
                        <input name="startup_name" value="{{ old('startup_name', $user->startup_name) }}" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Phone Number</label>
                        <input name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 40px; padding-top: 40px; border-top: 1px solid var(--border);">
                <h4 style="margin-top: 0; margin-bottom: 20px; color: var(--brand); text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">Communication Preferences</h4>
                <div style="display: grid; gap: 15px;">
                    <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                        <input type="checkbox" name="wants_email_notifications" value="1" @checked(old('wants_email_notifications', $user->wants_email_notifications)) style="width: 20px; height: 20px; accent-color: var(--brand);">
                        <span style="font-size: 14px; font-weight: 600;">Receive email notifications for ticket updates</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                        <input type="checkbox" name="wants_in_app_notifications" value="1" @checked(old('wants_in_app_notifications', $user->wants_in_app_notifications)) style="width: 20px; height: 20px; accent-color: var(--brand);">
                        <span style="font-size: 14px; font-weight: 600;">Enable in-app real-time alerts</span>
                    </label>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
