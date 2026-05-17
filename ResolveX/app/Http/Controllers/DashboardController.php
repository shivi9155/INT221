<?php

namespace App\Http\Controllers;

use App\Models\Grievance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user();
        $baseQuery = $user->isStaff()
            ? Grievance::query()
            : Grievance::query()->where('user_id', $user->id);

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->whereNot('status', 'Resolved')->count(),
            'resolved' => (clone $baseQuery)->where('status', 'Resolved')->count(),
            'high' => (clone $baseQuery)->where('priority', 'High')->count(),
            'escalated' => (clone $baseQuery)->whereNotNull('escalated_at')->count(),
            'overdue' => (clone $baseQuery)->where('status', '!=', 'Resolved')->whereNotNull('due_at')->where('due_at', '<', now())->count(),
        ];

        $driver = DB::connection()->getDriverName();
        $monthly = [];

        if ($driver === 'mongodb') {
            $monthly = (clone $baseQuery)->get()
                ->groupBy(fn ($g) => $g->created_at?->format('Y-m') ?? 'Unknown')
                ->map(fn ($group) => $group->count())
                ->sortKeys()
                ->take(6);
        } else {
            $monthly = (clone $baseQuery)
                ->selectRaw("strftime('%Y-%m', created_at) as month, count(*) as total")
                ->groupBy('month')
                ->orderBy('month')
                ->limit(6)
                ->pluck('total', 'month');
        }

        $recent = (clone $baseQuery)
            ->with(['user', 'assignee', 'feedback'])
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'monthly' => $monthly,
            'recent' => $recent,
            'notifications' => $user->notifications()->latest()->limit(5)->get(),
        ]);
    }
}
