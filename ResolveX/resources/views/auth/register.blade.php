@extends('layouts.app')

@section('content')
<section class="card">
    <span class="soft-note">Onboard your startup team</span>
    <h1 class="title" style="margin-top:18px;">Create account</h1>
    <p class="subtitle">Register as a founder or employee and start managing issues in a more structured way.</p>

    <form method="POST" action="{{ route('register') }}" class="grid" style="margin-top:20px">
        @csrf
        <div>
            <label>Name</label>
            <input name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label>Email</label>
            <input name="email" type="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Startup role</label>
            <select name="user_type" required>
                <option value="founder" @selected(old('user_type', 'founder') === 'founder')>Founder</option>
                <option value="employee" @selected(old('user_type') === 'employee')>Employee</option>
            </select>
        </div>
        <div>
            <label>Startup name</label>
            <input name="startup_name" value="{{ old('startup_name') }}">
        </div>
        <div class="full">
            <label>Phone</label>
            <input name="phone" value="{{ old('phone') }}">
        </div>
        <div>
            <label>Password</label>
            <input name="password" type="password" required>
        </div>
        <div>
            <label>Confirm password</label>
            <input name="password_confirmation" type="password" required>
        </div>
        <button class="btn" type="submit">Register</button>
    </form>

    <p class="subtitle" style="margin-top:16px">Already registered? <a href="{{ route('login') }}"><strong>Login</strong></a></p>
</section>
@endsection
