@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    <div style="width: 100%; max-width: 560px; background: var(--card-bg); border: 1px solid var(--border); border-radius: 32px; padding: 48px; box-shadow: 0 40px 100px rgba(0,0,0,0.5); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: var(--brand); filter: blur(70px); opacity: 0.12; z-index: 0;"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: #8b5cf6; filter: blur(70px); opacity: 0.08; z-index: 0;"></div>

        <div style="position: relative; z-index: 1;">
            <div style="text-align: center; margin-bottom: 40px;">
                <div style="width: 64px; height: 64px; background: var(--brand); border-radius: 20px; margin: 0 auto 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(255,107,0,0.3);">
                    <svg style="width: 32px; height: 32px; color: #000;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h1 style="font-size: 30px; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px;">Create Account</h1>
                <p style="opacity: 0.5; font-weight: 500;">Join the ResolveX platform for your startup.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" style="display: grid; gap: 20px;">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                            style="width: 100%; padding: 14px; border-radius: 14px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                            onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="name@startup.com"
                            style="width: 100%; padding: 14px; border-radius: 14px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                            onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Startup Name</label>
                        <input type="text" name="startup_name" value="{{ old('startup_name') }}" placeholder="Acme Corp"
                            style="width: 100%; padding: 14px; border-radius: 14px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                            onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Role</label>
                        <select name="user_type" required style="width: 100%; padding: 14px; border-radius: 14px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; font-weight: 600;">
                            <option value="founder">Founder</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Password</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            style="width: 100%; padding: 14px; border-radius: 14px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                            onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                    <div>
                        <label style="display: block; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--brand); margin-bottom: 8px;">Confirm Password</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                            style="width: 100%; padding: 14px; border-radius: 14px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); color: var(--text); outline: none; transition: all 0.3s; font-weight: 600;"
                            onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 18px; justify-content: center; font-size: 16px; letter-spacing: 1px; text-transform: uppercase; margin-top: 8px;">
                    Initialize Account
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>

            <div style="margin-top: 28px; text-align: center; font-size: 14px; padding-top: 24px; border-top: 1px solid var(--border);">
                <span style="opacity: 0.5; font-weight: 500;">Already have an account?</span>
                <a href="{{ route('login') }}" style="color: var(--brand); font-weight: 800; text-decoration: none; margin-left: 8px;">Sign in instead</a>
            </div>
        </div>
    </div>
</div>
@endsection

