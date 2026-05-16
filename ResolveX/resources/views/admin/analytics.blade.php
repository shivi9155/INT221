@extends('admin.layout')

@section('title', 'System Analytics')

@section('admin-content')
<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
    <div>
        <h1 style="font-size: 36px; font-weight: 900; margin: 0; letter-spacing: -1px;">System <span style="color: var(--brand);">Intelligence</span></h1>
        <p style="opacity: 0.5; margin-top: 10px; font-size: 16px;">Comprehensive data insights into resolution performance and user satisfaction.</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <a href="{{ route('admin.export') }}" class="btn btn-primary">
            <svg style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export CSV
        </a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; margin-bottom: 40px;">
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Resolution Rate</div>
        <div style="font-size: 28px; font-weight: 900; color: #10b981;">{{ $analytics['resolution_rate'] }}%</div>
        <div style="margin-top: 12px; height: 4px; background: var(--border); border-radius: 2px; overflow: hidden;">
            <div style="width: {{ $analytics['resolution_rate'] }}%; height: 100%; background: #10b981;"></div>
        </div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Avg Response</div>
        <div style="font-size: 28px; font-weight: 900;">{{ $analytics['avg_response_time'] }}h</div>
        <div style="font-size: 11px; opacity: 0.5; margin-top: 4px;">Time to first engagement</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Resolution Cycle</div>
        <div style="font-size: 28px; font-weight: 900;">{{ $analytics['avg_resolution_time'] }}d</div>
        <div style="font-size: 11px; opacity: 0.5; margin-top: 4px;">Average days to close</div>
    </div>
    <div class="card">
        <div style="font-size: 11px; font-weight: 800; opacity: 0.4; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Satisfaction</div>
        <div style="font-size: 28px; font-weight: 900; color: var(--brand);">{{ $analytics['satisfaction_rate'] }}%</div>
        <div style="font-size: 11px; opacity: 0.5; margin-top: 4px;">Based on user feedback</div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; margin-bottom: 30px;">
    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 30px;">Grievance Velocity</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 30px;">Triage Distribution</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 30px;">Priority Mix</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="priorityChart"></canvas>
        </div>
    </div>
    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 30px;">Category Breakdown</h3>
        <div style="height: 300px; position: relative;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 24px;">Top Performing Categories</h3>
        <div style="display: grid; gap: 16px;">
            @foreach($analytics['top_categories'] as $category)
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; font-weight: 700;">
                        <span>{{ $category->category }}</span>
                        <span>{{ $category->count }} cases</span>
                    </div>
                    <div style="height: 6px; background: var(--border); border-radius: 3px; overflow: hidden;">
                        <div style="width: {{ $analytics['top_categories']->count() > 0 ? ($category->count / $analytics['top_categories']->first()->count) * 100 : 0 }}%; height: 100%; background: var(--brand);"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card">
        <h3 style="margin-top: 0; margin-bottom: 24px;">Response Performance</h3>
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; justify-content: space-between; padding: 12px; background: rgba(16,185,129,0.05); border-radius: 12px; border: 1px solid rgba(16,185,129,0.1);">
                <span style="font-weight: 700;">Instant (&lt; 1h)</span>
                <span style="font-weight: 900; color: #10b981;">{{ $analytics['response_times']['under_1h'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--bg); border-radius: 12px; border: 1px solid var(--border);">
                <span style="font-weight: 700;">Active (1-24h)</span>
                <span style="font-weight: 900;">{{ $analytics['response_times']['1_24h'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--bg); border-radius: 12px; border: 1px solid var(--border);">
                <span style="font-weight: 700;">Delayed (1-7d)</span>
                <span style="font-weight: 900;">{{ $analytics['response_times']['1_7d'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px; background: rgba(239,68,68,0.05); border-radius: 12px; border: 1px solid rgba(239,68,68,0.1);">
                <span style="font-weight: 700;">Critical (&gt; 7d)</span>
                <span style="font-weight: 900; color: #ef4444;">{{ $analytics['response_times']['over_7d'] }}</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#ffffff' : '#0a0a0a';
    const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

    Chart.defaults.color = textColor;
    Chart.defaults.font.family = "'Instrument Sans', sans-serif";
    Chart.defaults.font.weight = '600';

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 20, usePointStyle: true }
            }
        }
    };

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: @json($analytics['status_labels']),
            datasets: [{
                data: @json($analytics['status_data']),
                backgroundColor: ['#ff6b00', '#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            ...commonOptions,
            cutout: '70%'
        }
    });

    new Chart(document.getElementById('categoryChart'), {
        type: 'bar',
        data: {
            labels: @json($analytics['category_labels']),
            datasets: [{
                label: 'Tickets',
                data: @json($analytics['category_data']),
                backgroundColor: '#ff6b00',
                borderRadius: 8
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { grid: { color: gridColor }, beginAtZero: true },
                x: { grid: { display: false } }
            },
            plugins: { legend: { display: false } }
        }
    });

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: @json($analytics['monthly_labels']),
            datasets: [{
                label: 'Inflow',
                data: @json($analytics['monthly_data']),
                borderColor: '#ff6b00',
                backgroundColor: 'rgba(255,107,0,0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 4,
                pointBackgroundColor: '#ff6b00'
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                y: { grid: { color: gridColor }, beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });

    new Chart(document.getElementById('priorityChart'), {
        type: 'polarArea',
        data: {
            labels: @json($analytics['priority_labels']),
            datasets: [{
                data: @json($analytics['priority_data']),
                backgroundColor: ['rgba(239,68,68,0.7)', 'rgba(245,158,11,0.7)', 'rgba(16,185,129,0.7)'],
                borderWidth: 0
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                r: { grid: { color: gridColor }, ticks: { display: false } }
            }
        }
    });
});
</script>
@endsection
