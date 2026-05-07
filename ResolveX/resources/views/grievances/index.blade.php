@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <h1 class="title">Grievances</h1>
        <p class="subtitle">Search, filter, and track every ticket.</p>
    </div>
    <a class="btn" href="{{ route('grievances.create') }}">Submit</a>
</div>

<form class="card filters" method="GET">
    <div>
        <label>Search</label>
        <input name="search" value="{{ request('search') }}" placeholder="Ticket ID, subject, keyword">
    </div>
    <div>
        <label>Status</label>
        <select name="status"><option value="">All</option>@foreach($statuses as $status)<option @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select>
    </div>
    <div>
        <label>Category</label>
        <select name="category"><option value="">All</option>@foreach($categories as $category)<option @selected(request('category')===$category)>{{ $category }}</option>@endforeach</select>
    </div>
    <div>
        <label>Priority</label>
        <select name="priority"><option value="">All</option>@foreach($priorities as $priority)<option @selected(request('priority')===$priority)>{{ $priority }}</option>@endforeach</select>
    </div>
    <button class="btn" type="submit">Filter</button>
</form>

<section class="card" style="margin-top:16px">
    @include('grievances._table', ['grievances' => $grievances])
    <div style="margin-top:16px">{{ $grievances->links() }}</div>
</section>
@endsection
