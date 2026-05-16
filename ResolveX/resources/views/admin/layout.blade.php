@extends('layouts.app')

@section('title', $title ?? 'Admin Dashboard')

@section('content')
@if(session('status') || session('success'))
    <div class="alert">
        {{ session('status') ?? session('success') }}
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

@push('scripts')
@yield('admin-scripts')
@endpush

