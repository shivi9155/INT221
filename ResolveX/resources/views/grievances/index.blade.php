@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <span class="soft-note">Search, triage, and follow-through</span>
        <h1 class="title" style="margin-top:14px;">Grievances</h1>
        <p class="subtitle">Search, filter, and track every ticket from intake to closure.</p>
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
    <div>
        <label>Sentiment</label>
        <select name="sentiment"><option value="">All</option>@foreach($sentiments as $sentiment)<option @selected(request('sentiment')===$sentiment)>{{ $sentiment }}</option>@endforeach</select>
    </div>
    <div>
        <label>From</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}">
    </div>
    <div>
        <label>To</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}">
    </div>
    <button class="btn" type="submit">Filter</button>
</form>

<section class="card" style="margin-top:16px">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; flex-wrap:wrap; margin-bottom:14px;">
        <div>
            <h2 style="margin:0;">Ticket queue</h2>
            <p class="subtitle">Use keywords, sentiment, and dates to narrow the list quickly.</p>
        </div>
        <div class="soft-note">Showing {{ $grievances->total() }} tickets</div>
    </div>
    @include('grievances._table', ['grievances' => $grievances])
    <div style="margin-top:16px">{{ $grievances->links() }}</div>
</section>
@endsection
