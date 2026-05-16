@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div class="glass-login-card" style="width: 100%; max-width: 480px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 32px; padding: 48px; box-shadow: 0 40px 100px rgba(0,0,0,0.5); position: relative; overflow: hidden;">
        <!-- Animated Background Blur -->
        <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: var(--brand); filter: blur(70px); opacity: 0.15; z-index: 0;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: #8b5cf6; filter: blur(70px); opacity: 0.1; z-index: 0;"></div>

        <div style="position: relative; z-index: 1;">
            <div style="text-align: center; margin-bottom: 40px;">
                <div style="width: 64px; height: 64px; background: var(--brand); border-radius: 20px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(255,107,0,0.3);">
                    <svg style="width: 32px; height: 32px; color: #000;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-10.428A9.956 9.956 0 0112 2c4.474 0 8.268 2.943 9.542 7m-1.207 6.593A9.956 9.956 0 0110 22c-5.523 0-10-4.477-10-10 0-2.31.783-4.437 2.103-6.13"></path></svg>
                </div>
                <h1 style="font-size: 32px; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px;">{{ $portalTitle ?? 'User Login' }}</h1>
                <p style="color: var(--text); opacity: 0.5; font-weight: 500;">{{ $portalSubtitle ?? 'Access your grievance dashboard' }}</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 28px;">
                <a href="{{ route('user.login') }}" class="btn {{ ($portal ?? 'user') === 'user' ? 'btn-primary' : 'btn-secondary' }}" style="justify-content:center; text-decoration:none;">User Login</a>
                <a href="{{ route('admin.login') }}" class="btn {{ ($portal ?? 'user') === 'admin' ? 'btn-primary' : 'btn-secondary' }}" style="justify-content:center; text-decoration:none;">Admin Login</a>
            </div>

            <form method="POST" action="{{ $loginRoute ?? route('user.login.store') }}" style="display: grid; gap: 24px;">
                @csrf
                <div class="form-group">
                    <label style="display: block; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 10px;">Operator ID (Email)</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{ $sampleEmail ?? 'founder@gmail.com' }}" 
                        style="width: 100%; padding: 16px; border-radius: 16px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                        onfocus="this.style.borderColor='var(--brand)'; this.style.background='rgba(255,255,255,0.05)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.background='rgba(255,255,255,0.03)'">
                </div>

                <div class="form-group">
                    <label style="display: block; font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 10px;">Access Key (Password)</label>
                    <input type="password" name="password" required placeholder="password"
                        style="width: 100%; padding: 16px; border-radius: 16px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                        onfocus="this.style.borderColor='var(--brand)'; this.style.background='rgba(255,255,255,0.05)'"
                        onblur="this.style.borderColor='var(--border)'; this.style.background='rgba(255,255,255,0.03)'">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 14px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; opacity: 0.7;">
                        <input type="checkbox" name="remember" style="accent-color: var(--brand);"> Remember for 30 days
                    </label>
                    <a href="#" style="color: var(--brand); font-weight: 700; text-decoration: none; opacity: 0.8; transition: opacity 0.2s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.8'">Forgot key?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; justify-content: center; font-size: 16px; letter-spacing: 1px; text-transform: uppercase;">
                    {{ ($portal ?? 'user') === 'admin' ? 'Enter Admin Panel' : 'Enter User Portal' }}
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div style="margin-top: 32px; text-align: center; font-size: 14px; padding-top: 24px; border-top: 1px solid var(--border);">
                @if(($portal ?? 'user') === 'user')
                    <span style="opacity: 0.5; font-weight: 500;">New to the platform?</span>
                    <a href="{{ route('register') }}" style="color: var(--brand); font-weight: 800; text-decoration: none; margin-left: 8px;">Create an account</a>
                @else
                    <span style="opacity: 0.5; font-weight: 500;">Not an admin?</span>
                    <a href="{{ route('user.login') }}" style="color: var(--brand); font-weight: 800; text-decoration: none; margin-left: 8px;">Go to User Login</a>
                @endif
            </div>
            
            <div style="margin-top: 30px; padding: 20px; border-radius: 20px; background: rgba(255,107,0,0.05); border: 1px solid var(--border);">
                <div style="font-weight: 800; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; color: var(--brand); display: flex; align-items: center; gap: 6px;">
                    <svg style="width:14px;height:14px" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                    {{ ($portal ?? 'user') === 'admin' ? 'Admin Credentials' : 'User Credentials' }}
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                    <span style="opacity: 0.6;">Email: {{ $sampleEmail ?? 'founder@gmail.com' }}</span>
                    <span style="opacity: 0.6;">Pass: password</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
