@extends('layouts.app')

@section('title', $title ?? 'Admin Dashboard')

@section('content')
<div style="margin-bottom: 20px;">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">{{ $title ?? 'Admin Dashboard' }}</h1>
    <p style="color: var(--muted);">Manage grievances and user communications</p>
</div>

@if(session('success'))
    <div class="alert">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="errors">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@yield('admin-content')
@endsection
