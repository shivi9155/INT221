<?php

namespace App\Http\Controllers;

use App\Models\Grievance;
use Illuminate\Http\Request;
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
        ];

        $monthly = (clone $baseQuery)
            ->selectRaw("strftime('%Y-%m', created_at) as month, count(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->limit(6)
            ->pluck('total', 'month');

        $recent = (clone $baseQuery)
            ->with(['user', 'assignee'])
            ->latest()
            ->limit(8)
            ->get();

        return view('dashboard', compact('stats', 'monthly', 'recent'));
    }
}
