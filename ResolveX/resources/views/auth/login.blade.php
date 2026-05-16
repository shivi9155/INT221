@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin-top:0">Welcome Back</h2>
    <p style="opacity: 0.6; margin-bottom: 24px;">Sign in to manage your startup grievances.</p>

    <form method="POST" action="{{ route('login') }}" style="display: grid; gap: 16px;">
        @csrf
        <div>
            <label style="display:block; margin-bottom: 8px; font-weight: 700;">Email Address</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
        </div>
        <div>
            <label style="display:block; margin-bottom: 8px; font-weight: 700;">Password</label>
            <input type="password" name="password" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">Sign In</button>
    </form>

    <div style="margin-top: 24px; text-align: center; font-size: 14px;">
        <span style="opacity: 0.6;">Don't have an account?</span>
        <a href="{{ route('register') }}" style="color: var(--brand); font-weight: 700;">Register here</a>
    </div>

    <div style="margin-top: 30px; padding: 20px; border-radius: 20px; background: rgba(255,107,0,0.05); border: 1px solid var(--border);">
        <div style="font-weight: 800; font-size: 13px; text-transform: uppercase; margin-bottom: 8px; color: var(--brand);">Demo Access</div>
        <div style="font-size: 13px; opacity: 0.8;">Admin: admin@resolvex.test</div>
        <div style="font-size: 13px; opacity: 0.8;">Pass: password</div>
    </div>
</div>
@endsection
