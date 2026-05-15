@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <h1 class="title">Profile</h1>
        <p class="subtitle">Manage founder or employee details.</p>
    </div>
</div>

<form method="POST" action="{{ route('profile.update') }}" class="card form-grid">
    @csrf
    @method('PUT')
    <div>
        <label>Name</label>
        <input name="name" value="{{ old('name', $user->name) }}" required>
    </div>
    <div>
        <label>Email</label>
        <input value="{{ $user->email }}" disabled>
    </div>
    <div>
        <label>Startup name</label>
        <input name="startup_name" value="{{ old('startup_name', $user->startup_name) }}">
    </div>
    <div>
        <label>Phone</label>
        <input name="phone" value="{{ old('phone', $user->phone) }}">
    </div>
    <div>
        <label>Role</label>
        <input value="{{ ucfirst($user->role) }}" disabled>
    </div>
    <div>
        <label>Startup role</label>
        <input value="{{ ucfirst($user->user_type) }}" disabled>
    </div>
    <div>
        <label style="display:flex; gap:8px; align-items:center; font-weight:600">
            <input style="width:auto" type="checkbox" name="wants_email_notifications" value="1" @checked(old('wants_email_notifications', $user->wants_email_notifications))>
            Email notifications
        </label>
    </div>
    <div>
        <label style="display:flex; gap:8px; align-items:center; font-weight:600">
            <input style="width:auto" type="checkbox" name="wants_in_app_notifications" value="1" @checked(old('wants_in_app_notifications', $user->wants_in_app_notifications))>
            In-app notifications
        </label>
    </div>
    <div class="full">
        <button class="btn" type="submit">Save profile</button>
    </div>
</form>
@endsection
