@extends('layouts.app')

@section('content')
<section class="card">
    <h1 class="title">Sign in</h1>
    <p class="subtitle">Track and resolve startup grievances.</p>

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

    <p class="subtitle" style="margin-top:16px">New founder or employee? <a href="{{ route('register') }}"><strong>Create account</strong></a></p>
    <p class="subtitle" style="margin-top:10px">Demo admin: <strong>admin@resolvex.test</strong> / <strong>password</strong></p>
</section>
@endsection
