<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Grievance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request, Grievance $grievance): RedirectResponse
    {
        abort_unless($grievance->user_id === $request->user()->id && $grievance->status === 'Resolved', 403);

        $data = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ]);

        Feedback::updateOrCreate(
            ['grievance_id' => $grievance->id],
            ['user_id' => $request->user()->id, ...$data]
        );

        return back()->with('status', 'Thanks for your feedback.');
    }
}
