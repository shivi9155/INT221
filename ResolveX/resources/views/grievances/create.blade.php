@extends('layouts.app')

@section('content')
<div style="margin-bottom: 30px;">
    <h1 style="font-size: 32px; font-weight: 800; margin: 0;">Submit New Grievance</h1>
    <p style="opacity: 0.6; margin-top: 8px;">Fill out the details below to open a new support ticket.</p>
</div>

<div style="max-width: 800px;">
    <form action="{{ route('grievances.store') }}" method="POST" enctype="multipart/form-data" class="card" style="display: grid; gap: 24px;">
        @csrf
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Category</label>
                <select name="category" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                    @foreach($categories as $category)
                        <option @selected(old('category')===$category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Priority Level</label>
                <select name="priority" required style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
                    @foreach($priorities as $priority)
                        <option @selected(old('priority', 'Medium')===$priority)>{{ $priority }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Subject</label>
            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="Briefly describe the issue" style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text);">
        </div>

        <div>
            <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Detailed Description</label>
            <textarea name="description" required placeholder="Provide as much detail as possible..." style="width: 100%; padding: 12px; border-radius: 12px; border: 1px solid var(--border); background: var(--bg); color: var(--text); min-height: 150px;">{{ old('description') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; align-items: center;">
            <div>
                <label style="display:block; margin-bottom: 8px; font-size: 13px; font-weight: 700;">Attachment (Optional)</label>
                <input type="file" name="attachment" accept=".pdf,.png,.jpg,.jpeg" style="width: 100%; padding: 8px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg); color: var(--text); font-size: 13px;">
            </div>
            <div style="padding-top: 25px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_anonymous" value="1" @checked(old('is_anonymous')) style="width: 18px; height: 18px; accent-color: var(--brand);">
                    <span style="font-size: 14px; font-weight: 600;">Submit Anonymously</span>
                </label>
            </div>
        </div>

        <div style="padding: 15px; border-radius: 12px; background: rgba(255,107,0,0.05); border: 1px solid var(--border); font-size: 13px; opacity: 0.8;">
            <strong>Note:</strong> Our AI will automatically classify your ticket and estimate sentiment to ensure it reaches the right team quickly.
        </div>

        <div style="display: flex; gap: 12px; margin-top: 10px;">
            <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">Create Ticket</button>
            <a href="{{ route('grievances.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
