@extends('admin.layout')

@section('title', 'Analytics Dashboard')

@section('admin-content')
<div class="grid" style="gap: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; flex-wrap: wrap;">
        <div>
            <h2 style="margin: 0; font-size: 28px; font-weight: 800;">Analytics Dashboard</h2>
            <p class="muted" style="margin-top: 8px;">Comprehensive insights into grievance management</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" class="btn secondary">&larr; Back to Dashboard</a>
            <a href="{{ route('admin.export') }}" class="btn">Export Report</a>
        </div>
    </div>

    <div class="grid grid-4">
        <div class="card">
            <div class="muted">Resolution Rate</div>
            <div class="stat">{{ $analytics['resolution_rate'] }}%</div>
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 12px;">
                <div class="bar" style="flex: 1;">
                    <span style="width: {{ $analytics['resolution_rate'] }}%;"></span>
                </div>
                <small class="muted">{{ $analytics['resolved_count'] }}/{{ $analytics['total_grievances'] }}</small>
            </div>
        </div>

        <div class="card">
            <div class="muted">Avg Response Time</div>
            <div class="stat">{{ $analytics['avg_response_time'] }}h</div>
            <small class="muted">Time to first response</small>
        </div>

        <div class="card">
            <div class="muted">Avg Resolution Time</div>
            <div class="stat">{{ $analytics['avg_resolution_time'] }}d</div>
            <small class="muted">From submission to resolution</small>
        </div>

        <div class="card">
            <div class="muted">User Satisfaction</div>
            <div class="stat">{{ $analytics['satisfaction_rate'] }}%</div>
            <small class="muted">Based on feedback ratings</small>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h3 style="margin-top: 0;">Grievance Status Distribution</h3>
            <div style="height: 320px;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Grievances by Category</h3>
            <div style="height: 320px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h3 style="margin-top: 0;">Monthly Grievance Trends</h3>
            <div style="height: 320px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Priority Distribution</h3>
            <div style="height: 320px;">
                <canvas id="priorityChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h3 style="margin-top: 0;">Top Categories</h3>
            <div class="grid" style="gap: 12px;">
                @forelse($analytics['top_categories'] as $category)
                    <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                        <span>{{ $category->category }}</span>
                        <div style="display: flex; align-items: center; gap: 10px; min-width: 180px;">
                            <div class="bar" style="flex: 1;">
                                <span style="width: {{ $analytics['top_categories']->count() > 0 ? ($category->count / $analytics['top_categories']->first()->count) * 100 : 0 }}%;"></span>
                            </div>
                            <strong>{{ $category->count }}</strong>
                        </div>
                    </div>
                @empty
                    <p class="muted" style="margin: 0;">No category data available.</p>
                @endforelse
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Response Time Distribution</h3>
            <div class="grid" style="gap: 12px;">
                <div style="display: flex; justify-content: space-between;"><span>&lt; 1 hour</span><strong>{{ $analytics['response_times']['under_1h'] }}</strong></div>
                <div style="display: flex; justify-content: space-between;"><span>1-24 hours</span><strong>{{ $analytics['response_times']['1_24h'] }}</strong></div>
                <div style="display: flex; justify-content: space-between;"><span>1-7 days</span><strong>{{ $analytics['response_times']['1_7d'] }}</strong></div>
                <div style="display: flex; justify-content: space-between;"><span>&gt; 7 days</span><strong>{{ $analytics['response_times']['over_7d'] }}</strong></div>
            </div>
        </div>
    </div>

    <div class="card">
        <h3 style="margin-top: 0;">Most Active Users</h3>
        <div class="grid" style="gap: 12px;">
            @forelse($analytics['most_active_users'] as $user)
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>{{ $user->name }}</span>
                    <strong>{{ $user->grievance_count }}</strong>
                </div>
            @empty
                <p class="muted" style="margin: 0;">No user activity yet.</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 20px;">
            <div>
                <h3 style="margin: 0;">Detailed Reports</h3>
                <p class="muted" style="margin: 8px 0 0;">Quick summary for the current grievance dataset</p>
            </div>
            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <select id="reportType" style="min-width: 180px;">
                    <option value="weekly">Weekly Report</option>
                    <option value="monthly">Monthly Report</option>
                    <option value="quarterly">Quarterly Report</option>
                </select>
                <button type="button" class="btn" onclick="generateReport()">Generate Report</button>
            </div>
        </div>

        <div class="grid grid-4">
            <div class="card" style="padding: 16px; text-align: center;">
                <div class="stat" style="font-size: 24px;">{{ $analytics['total_grievances'] }}</div>
                <div class="muted">Total Grievances</div>
            </div>
            <div class="card" style="padding: 16px; text-align: center;">
                <div class="stat" style="font-size: 24px;">{{ $analytics['resolved_count'] }}</div>
                <div class="muted">Resolved</div>
            </div>
            <div class="card" style="padding: 16px; text-align: center;">
                <div class="stat" style="font-size: 24px;">{{ $analytics['pending_count'] }}</div>
                <div class="muted">Pending</div>
            </div>
            <div class="card" style="padding: 16px; text-align: center;">
                <div class="stat" style="font-size: 24px;">{{ $analytics['escalated_count'] }}</div>
                <div class="muted">Escalated</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
    };

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($analytics['status_labels']),
            datasets: [{
                data: @json($analytics['status_data']),
                backgroundColor: ['#067647', '#175cd3', '#b54708', '#667085', '#b42318'],
                borderWidth: 0
            }]
        },
        options: {
            ...chartDefaults,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: @json($analytics['category_labels']),
            datasets: [{
                label: 'Grievances',
                data: @json($analytics['category_data']),
                backgroundColor: '#176b87',
                borderRadius: 6
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: @json($analytics['monthly_labels']),
            datasets: [{
                label: 'New Grievances',
                data: @json($analytics['monthly_data']),
                borderColor: '#0f8b8d',
                backgroundColor: 'rgba(15, 139, 141, 0.12)',
                fill: true,
                tension: 0.35
            }]
        },
        options: {
            ...chartDefaults,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    new Chart(document.getElementById('priorityChart'), {
        type: 'pie',
        data: {
            labels: @json($analytics['priority_labels']),
            datasets: [{
                data: @json($analytics['priority_data']),
                backgroundColor: ['#b42318', '#b54708', '#067647'],
                borderWidth: 0
            }]
        },
        options: {
            ...chartDefaults,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});

function generateReport() {
    const reportType = document.getElementById('reportType').value;
    const url = new URL(window.location.href);
    url.searchParams.set('report', reportType);
    window.location.href = url.toString();
}
</script>
@endsection
