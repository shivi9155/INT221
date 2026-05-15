<?php

namespace App\Http\Controllers;

use App\Models\Grievance;
use App\Models\GrievanceUpdate;
use App\Models\User;
use App\Notifications\GrievanceActivityNotification;
use App\Services\GrievanceIntelligenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GrievanceController extends Controller
{
    public function __construct(private readonly GrievanceIntelligenceService $intelligence)
    {
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $query = Grievance::with(['user', 'assignee', 'escalatedTo'])->latest();

        if (! $user->isStaff()) {
            $query->where('user_id', $user->id);
        }

        foreach (['status', 'category', 'priority'] as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->string($filter));
            }
        }

        if ($request->filled('sentiment')) {
            $query->where('sentiment_label', $request->string('sentiment'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date('date_to'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($builder) use ($search) {
                $builder->where('ticket_id', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ai_category', 'like', "%{$search}%");
            });
        }

        $grievances = $query->paginate(10)->withQueryString();

        return view('grievances.index', [
            'grievances' => $grievances,
            'categories' => Grievance::CATEGORIES,
            'priorities' => Grievance::PRIORITIES,
            'statuses' => Grievance::STATUSES,
            'sentiments' => ['Critical', 'Concerned', 'Neutral', 'Calm'],
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
        $aiCategory = $this->intelligence->suggestCategory($data['subject'], $data['description'], $data['category']);
        $sentiment = $this->intelligence->analyzeSentiment($data['subject'], $data['description'], $data['priority']);
        $slaHours = $this->intelligence->determineSlaHours($data['priority'], $sentiment['label']);

        $grievance = Grievance::create([
            ...$data,
            'ticket_id' => $ticketId,
            'user_id' => $request->user()->id,
            'ai_category' => $aiCategory,
            'sentiment_label' => $sentiment['label'],
            'sentiment_score' => $sentiment['score'],
            'is_anonymous' => $request->boolean('is_anonymous'),
            'attachment_path' => $attachmentPath,
            'sla_hours' => $slaHours,
            'due_at' => now()->addHours($slaHours),
        ]);

        $grievance->updates()->create([
            'user_id' => $request->user()->id,
            'status' => 'Submitted',
            'note' => 'Ticket submitted and queued for review. Smart classifier tagged this ticket as '.$aiCategory.' with '.$sentiment['label'].' sentiment.',
        ]);

        $this->notifyStakeholders(
            $grievance->load('user'),
            'Complaint submitted',
            'Your grievance has been submitted and is now waiting for review.'
        );

        return redirect()->route('grievances.show', $grievance)->with('status', "Ticket {$ticketId} submitted.");
    }

    public function show(Request $request, Grievance $grievance): View
    {
        $this->authorizeAccess($request, $grievance);

        return view('grievances.show', [
            'grievance' => $grievance->load(['user', 'assignee', 'escalatedTo', 'updates.user', 'feedback']),
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
            'resolution_summary' => ['nullable', 'string', 'max:1500'],
        ]);

        $grievance->update([
            'status' => $data['status'],
            'assigned_to' => $data['assigned_to'] ?? null,
            'resolved_at' => $data['status'] === 'Resolved' ? now() : null,
            'resolution_summary' => $data['resolution_summary'] ?? $grievance->resolution_summary,
        ]);

        $this->applyEscalationRules($grievance, $request->user());

        GrievanceUpdate::create([
            'grievance_id' => $grievance->id,
            'user_id' => $request->user()->id,
            'status' => $data['status'],
            'note' => $data['note'] ?: 'Status updated to '.$data['status'].'.',
        ]);

        $this->notifyStakeholders(
            $grievance->fresh()->load('user'),
            'Complaint status updated',
            'Your grievance is now marked as '.$grievance->fresh()->status.'.'
        );

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

        $this->notifyStakeholders(
            $grievance->load('user'),
            'New ticket comment',
            'A new comment was added to grievance '.$grievance->ticket_id.'.'
        );

        return back()->with('status', 'Comment added.');
    }

    private function authorizeAccess(Request $request, Grievance $grievance): void
    {
        abort_unless($request->user()->isStaff() || $grievance->user_id === $request->user()->id, 403);
    }

    private function applyEscalationRules(Grievance $grievance, User $actor): void
    {
        if ($grievance->status === 'Resolved') {
            if ($grievance->escalated_at !== null) {
                $grievance->update([
                    'escalated_at' => null,
                    'escalated_to' => null,
                ]);
            }

            return;
        }

        if (! $grievance->isOverdue() && $grievance->priority !== 'High' && $grievance->sentiment_label !== 'Critical') {
            return;
        }

        $admin = User::query()->where('role', 'admin')->orderBy('id')->first();

        $grievance->update([
            'escalated_at' => $grievance->escalated_at ?? now(),
            'escalated_to' => $admin?->id,
        ]);

        $grievance->updates()->create([
            'user_id' => $actor->id,
            'status' => $grievance->status,
            'note' => 'Ticket escalated for faster review based on SLA or urgency.',
        ]);

        if ($admin) {
            $admin->notify(new GrievanceActivityNotification(
                $grievance,
                'Ticket escalated',
                'A grievance has been escalated and needs leadership attention.'
            ));
        }
    }

    private function notifyStakeholders(Grievance $grievance, string $title, string $message): void
    {
        $grievance->user?->notify(new GrievanceActivityNotification($grievance, $title, $message));

        if ($grievance->assignee && $grievance->assignee->isNot($grievance->user)) {
            $grievance->assignee->notify(new GrievanceActivityNotification(
                $grievance,
                $title,
                'An assigned grievance has new activity.'
            ));
        }
    }
}
