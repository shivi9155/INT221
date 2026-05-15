<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'startup_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'wants_email_notifications' => ['nullable', 'boolean'],
            'wants_in_app_notifications' => ['nullable', 'boolean'],
        ]);

        $request->user()->update([
            'name' => $data['name'],
            'startup_name' => $data['startup_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'wants_email_notifications' => $request->boolean('wants_email_notifications'),
            'wants_in_app_notifications' => $request->boolean('wants_in_app_notifications'),
        ]);

        return back()->with('status', 'Profile updated.');
    }
}
