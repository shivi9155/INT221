@extends('layouts.app')

@section('content')
<div class="top">
    <div>
        <h1 class="title">Submit grievance</h1>
        <p class="subtitle">Create a ticket with priority, category, and optional proof.</p>
    </div>
</div>

<form class="card form-grid" method="POST" action="{{ route('grievances.store') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label>Category</label>
        <select name="category" required>@foreach($categories as $category)<option @selected(old('category')===$category)>{{ $category }}</option>@endforeach</select>
    </div>
    <div>
        <label>Priority</label>
        <select name="priority" required>@foreach($priorities as $priority)<option @selected(old('priority', 'Medium')===$priority)>{{ $priority }}</option>@endforeach</select>
    </div>
    <div class="full">
        <label>Subject</label>
        <input name="subject" value="{{ old('subject') }}" required>
    </div>
    <div class="full">
        <label>Description</label>
        <textarea name="description" required>{{ old('description') }}</textarea>
    </div>
    <div>
        <label>Attachment</label>
        <input name="attachment" type="file" accept=".pdf,.png,.jpg,.jpeg">
    </div>
    <div>
        <label>Privacy</label>
        <label style="display:flex; gap:8px; align-items:center; font-weight:600"><input style="width:auto" type="checkbox" name="is_anonymous" value="1" @checked(old('is_anonymous'))> Submit anonymously</label>
    </div>
    <div class="full"><button class="btn" type="submit">Create ticket</button></div>
</form>
@endsection
