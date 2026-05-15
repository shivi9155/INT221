@extends('layouts.app')

@section('content')
<section class="card" style="padding:28px;">
    <span class="soft-note">Secure workspace access</span>
    <h1 class="title" style="margin-top:18px;">Sign in</h1>
    <p class="subtitle">Step back into the grievance workspace and keep every case moving.</p>

    <form method="POST" action="{{ route('login') }}" class="grid" style="margin-top:20px">
        @csrf
        <div>
            <label>Email</label>
            <input name="email" type="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password" required>
        </div>
        <button class="btn" type="submit">Login</button>
    </form>

    <div class="card" style="margin-top:18px; padding:18px; border-radius:20px; background:linear-gradient(180deg, #fbfdff, #eef4fa);">
        <div style="font-weight:800; margin-bottom:8px;">Demo access</div>
        <div class="subtitle" style="margin:0;">Admin: <strong>admin@resolvex.test</strong> / <strong>password</strong></div>
    </div>
    <p class="subtitle" style="margin-top:16px">New founder or employee? <a href="{{ route('register') }}"><strong>Create account</strong></a></p>
</section>
@endsection
