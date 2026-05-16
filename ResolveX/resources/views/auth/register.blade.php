@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin-top:0">Create Account</h2>
    <p style="opacity: 0.6; margin-bottom: 24px;">Join the ResolveX platform for your startup.</p>

    <form method="POST" action="{{ route('register') }}" style="display: grid; gap: 16px;">
        @csrf
        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 700;">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 700;">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 700;">Startup Name</label>
                <input type="text" name="startup_name" value="{{ old('startup_name') }}" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 700;">Role</label>
                <select name="user_type" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                    <option value="founder">Founder</option>
                    <option value="employee">Employee</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 700;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-weight: 700;">Confirm Password</label>
                <input type="password" name="password_confirmation" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 10px;">Register Account</button>
    </form>

    <div style="margin-top: 24px; text-align: center; font-size: 14px;">
        <span style="opacity: 0.6;">Already have an account?</span>
        <a href="{{ route('login') }}" style="color: var(--brand); font-weight: 700;">Login here</a>
    </div>
</div>
@endsection
