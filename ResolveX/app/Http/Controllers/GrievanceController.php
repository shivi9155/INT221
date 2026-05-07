<?php

namespace App\Http\Controllers;

use App\Models\Grievance;
use App\Models\GrievanceUpdate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GrievanceController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Grievance::with(['user', 'assignee'])->latest();

        if (! $user->isStaff()) {
            $query->where('user_id', $user->id);
        }

        foreach (['status', 'category', 'priority'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->string($filter));
            }
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('ticket_id', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $grievances = $query->paginate(10)->withQueryString();

        return view('grievances.index', [
            'grievances' => $grievances,
            'categories' => Grievance::CATEGORIES,
            'priorities' => Grievance::PRIORITIES,
            'statuses' => Grievance::STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('grievances.create', [
            'categories' => Grievance::CATEGORIES,
            'priorities' => Grievance::PRIORITIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category' => ['required', 'in:'.implode(',', Grievance::CATEGORIES)],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'priority' => ['required', 'in:'.implode(',', Grievance::PRIORITIES)],
            'is_anonymous' => ['nullable', 'boolean'],
            'attachment' => ['nullable', 'file', 'max:4096', 'mimes:pdf,png,jpg,jpeg'],
        ]);

        $attachmentPath = $request->file('attachment')?->store('attachments', 'public');
        $ticketId = 'RX-'.now()->format('Ymd').'-'.Str::upper(Str::random(5));

        $grievance = Grievance::create([
            ...$data,
            'ticket_id' => $ticketId,
            'user_id' => $request->user()->id,
            'is_anonymous' => $request->boolean('is_anonymous'),
            'attachment_path' => $attachmentPath,
        ]);

        $grievance->updates()->create([
            'user_id' => $request->user()->id,
            'status' => 'Submitted',
            'note' => 'Ticket submitted and queued for review.',
        ]);

        return redirect()->route('grievances.show', $grievance)->with('status', "Ticket {$ticketId} submitted.");
    }

    public function show(Request $request, Grievance $grievance): View
    {
        $this->authorizeAccess($request, $grievance);

        return view('grievances.show', [
            'grievance' => $grievance->load(['user', 'assignee', 'updates.user', 'feedback']),
            'moderators' => User::whereIn('role', ['admin', 'moderator'])->orderBy('name')->get(),
            'statuses' => Grievance::STATUSES,
        ]);
    }

    public function update(Request $request, Grievance $grievance): RedirectResponse
    {
        abort_unless($request->user()->isStaff(), 403);

        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', Grievance::STATUSES)],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $grievance->update([
            'status' => $data['status'],
            'assigned_to' => $data['assigned_to'] ?? null,
            'resolved_at' => $data['status'] === 'Resolved' ? now() : null,
        ]);

        GrievanceUpdate::create([
            'grievance_id' => $grievance->id,
            'user_id' => $request->user()->id,
            'status' => $data['status'],
            'note' => $data['note'] ?: 'Status updated to '.$data['status'].'.',
        ]);

        return back()->with('status', 'Ticket updated.');
    }

    public function addComment(Request $request, Grievance $grievance): RedirectResponse
    {
        $this->authorizeAccess($request, $grievance);

        $data = $request->validate(['note' => ['required', 'string', 'max:1000']]);

        $grievance->updates()->create([
            'user_id' => $request->user()->id,
            'status' => $grievance->status,
            'note' => $data['note'],
        ]);

        return back()->with('status', 'Comment added.');
    }

    private function authorizeAccess(Request $request, Grievance $grievance): void
    {
        abort_unless($request->user()->isStaff() || $grievance->user_id === $request->user()->id, 403);
    }
}
