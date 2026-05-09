<?php

namespace App\Http\Controllers;

use App\Models\Grievance;
use App\Models\Feedback;
use App\Models\User;
use App\Models\GrievanceUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $grievances = Grievance::with(['user', 'assignee'])
            ->latest()
            ->paginate(20);

        return view('admin.dashboard', [
            'grievances' => $grievances,
        ]);
    }

    public function show(Grievance $grievance): View
    {
        $grievance->load(['user', 'assignee', 'updates.user']);

        return view('admin.show', [
            'grievance' => $grievance,
        ]);
    }

    public function update(Request $request, Grievance $grievance): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:Submitted,Under Review,In Progress,Resolved',
            'assigned_to' => 'nullable|exists:users,id',
            'admin_reply' => 'nullable|string|max:1000',
        ]);

        $grievance->update([
            'status' => $request->status,
            'assigned_to' => $request->assigned_to ?: null,
            'resolved_at' => $request->status === 'Resolved' ? now() : null,
        ]);

        // If admin added a reply, create an update
        if ($request->filled('admin_reply')) {
            GrievanceUpdate::create([
                'grievance_id' => $grievance->id,
                'user_id' => $request->user()->id,
                'status' => $request->status,
                'note' => $request->admin_reply,
            ]);
        }

        return redirect()->back()->with('success', 'Grievance updated successfully!');
    }

    public function analytics(): View
    {
        $grievances = Grievance::with(['updates', 'feedback'])->get();
        $totalGrievances = $grievances->count();
        $resolvedCount = $grievances->where('status', 'Resolved')->count();
        $pendingCount = $grievances->where('status', '!=', 'Resolved')->count();
        $escalatedCount = $grievances->where('status', 'Escalated')->count();

        $responseHours = $grievances
            ->map(function (Grievance $grievance): ?float {
                $firstUpdate = $grievance->updates->sortBy('created_at')->first();

                if (! $firstUpdate) {
                    return null;
                }

                return round($grievance->created_at->diffInMinutes($firstUpdate->created_at) / 60, 2);
            })
            ->filter(fn ($value) => $value !== null)
            ->values();

        $resolutionDays = $grievances
            ->filter(fn (Grievance $grievance) => $grievance->resolved_at !== null)
            ->map(fn (Grievance $grievance): float => round($grievance->created_at->diffInMinutes($grievance->resolved_at) / 1440, 2))
            ->values();

        $feedback = Feedback::query()->get();
        $averageRating = (float) $feedback->avg('rating');

        $statusCounts = $grievances
            ->countBy('status')
            ->sortKeys();

        $categoryCounts = $grievances
            ->countBy('category')
            ->sortDesc();

        $priorityCounts = collect(Grievance::PRIORITIES)
            ->mapWithKeys(fn (string $priority) => [$priority => $grievances->where('priority', $priority)->count()]);

        $monthlyCounts = $this->buildMonthlyCounts();

        $topCategories = Grievance::query()
            ->select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $mostActiveUsers = User::query()
            ->select('users.id', 'users.name', DB::raw('count(grievances.id) as grievance_count'))
            ->join('grievances', 'grievances.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('grievance_count')
            ->limit(5)
            ->get();

        $analytics = [
            'total_grievances' => $totalGrievances,
            'resolved_count' => $resolvedCount,
            'pending_count' => $pendingCount,
            'escalated_count' => $escalatedCount,
            'resolution_rate' => $totalGrievances > 0 ? round(($resolvedCount / $totalGrievances) * 100, 1) : 0,
            'avg_response_time' => $responseHours->isNotEmpty() ? round($responseHours->avg(), 1) : 0,
            'avg_resolution_time' => $resolutionDays->isNotEmpty() ? round($resolutionDays->avg(), 1) : 0,
            'satisfaction_rate' => $averageRating > 0 ? round(($averageRating / 5) * 100, 1) : 0,
            'status_labels' => $statusCounts->keys()->values(),
            'status_data' => $statusCounts->values(),
            'category_labels' => $categoryCounts->keys()->values(),
            'category_data' => $categoryCounts->values(),
            'priority_labels' => $priorityCounts->keys()->values(),
            'priority_data' => $priorityCounts->values(),
            'monthly_labels' => $monthlyCounts->keys()->values(),
            'monthly_data' => $monthlyCounts->values(),
            'top_categories' => $topCategories,
            'most_active_users' => $mostActiveUsers,
            'response_times' => [
                'under_1h' => $responseHours->filter(fn (float $hours) => $hours < 1)->count(),
                '1_24h' => $responseHours->filter(fn (float $hours) => $hours >= 1 && $hours < 24)->count(),
                '1_7d' => $responseHours->filter(fn (float $hours) => $hours >= 24 && $hours <= 168)->count(),
                'over_7d' => $responseHours->filter(fn (float $hours) => $hours > 168)->count(),
            ],
        ];

        return view('admin.analytics', [
            'analytics' => $analytics,
            'title' => 'Analytics Dashboard',
        ]);
    }

    public function export(): StreamedResponse
    {
        $fileName = 'analytics-report-' . now()->format('Y-m-d-His') . '.csv';
        $grievances = Grievance::with(['user', 'assignee', 'feedback'])->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        return Response::stream(function () use ($grievances): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Ticket ID',
                'Subject',
                'Category',
                'Priority',
                'Status',
                'Submitted By',
                'Assigned To',
                'Created At',
                'Resolved At',
                'Feedback Rating',
            ]);

            foreach ($grievances as $grievance) {
                fputcsv($handle, [
                    $grievance->ticket_id,
                    $grievance->subject,
                    $grievance->category,
                    $grievance->priority,
                    $grievance->status,
                    optional($grievance->user)->name ?? 'Anonymous',
                    optional($grievance->assignee)->name ?? 'Unassigned',
                    $grievance->created_at?->toDateTimeString(),
                    $grievance->resolved_at?->toDateTimeString(),
                    optional($grievance->feedback)->rating,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    private function buildMonthlyCounts(): Collection
    {
        $driver = DB::connection()->getDriverName();
        $monthExpression = match ($driver) {
            'sqlite' => "strftime('%Y-%m', created_at)",
            'mysql', 'mariadb' => "DATE_FORMAT(created_at, '%Y-%m')",
            'pgsql' => "to_char(created_at, 'YYYY-MM')",
            'sqlsrv' => "FORMAT(created_at, 'yyyy-MM')",
            default => "strftime('%Y-%m', created_at)",
        };

        return Grievance::query()
            ->selectRaw($monthExpression . ' as month, count(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->limit(6)
            ->get()
            ->pluck('total', 'month');
    }
}
