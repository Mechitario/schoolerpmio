@extends('layouts.app')

@section('title', 'Dashboard Report')
@section('breadcrumb', 'Dashboard Report')

@section('content')
<div class="space-y-6 max-w-6xl">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-gray-900 dark:text-white print:text-gray-900">Dashboard Report</h1>
        <div class="flex gap-2 print:hidden">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gradient-to-r from-cyan-500 to-violet-600 text-white hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                Print Report
            </button>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Back to Dashboard
            </a>
        </div>
    </div>

    <p class="text-sm text-gray-500 dark:text-slate-400 print:text-gray-600">Generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-6 shadow-sm dark:shadow-none print:bg-white print:border-gray-200 print:text-gray-900 print:shadow-none">
        <h2 class="text-gray-900 dark:text-white mb-4 print:text-gray-900">Summary</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-500 uppercase print:text-gray-500">Total Students</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white print:text-gray-900">{{ number_format($studentCount) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-500 uppercase print:text-gray-500">Active Staff</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white print:text-gray-900">{{ number_format($staffCount) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-500 uppercase print:text-gray-500">Revenue (Paid)</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white print:text-gray-900">${{ number_format($monthlyRevenue) }}</p>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500 dark:text-slate-500 uppercase print:text-gray-500">Pending Fees</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white print:text-gray-900">${{ number_format($pendingFees) }}</p>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 print:block">
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-6 shadow-sm dark:shadow-none print:bg-white print:border-gray-200">
            <h3 class="text-gray-900 dark:text-white mb-4 print:text-gray-900">Fee status distribution</h3>
            <div class="relative h-72 print:h-64">
                <canvas id="chart-fee-status" class="max-w-full"></canvas>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-6 shadow-sm dark:shadow-none print:bg-white print:border-gray-200">
            <h3 class="text-gray-900 dark:text-white mb-4 print:text-gray-900">Revenue by class</h3>
            <div class="relative h-72 print:h-64">
                <canvas id="chart-revenue-by-class" class="max-w-full"></canvas>
            </div>
        </div>
        @if(!empty($reportYear) && !empty($chartRevenueByMonth['labels']))
        <div class="lg:col-span-2 bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-6 shadow-sm dark:shadow-none print:bg-white print:border-gray-200">
            <h3 class="text-gray-900 dark:text-white mb-4 print:text-gray-900">Revenue by month ({{ $reportYear }})</h3>
            <div class="relative h-72 print:h-64">
                <canvas id="chart-revenue-by-month" class="max-w-full"></canvas>
            </div>
        </div>
        @endif
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm dark:shadow-none print:bg-white print:border-gray-200 print:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 print:border-gray-200 print:bg-gray-50">
            <h2 class="text-gray-900 dark:text-white print:text-gray-900">Recent Fee Collections</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 print:border-gray-200 print:bg-gray-50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider print:text-gray-600">Student</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider print:text-gray-600">Class</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right print:text-gray-600">Total</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right print:text-gray-600">Paid</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right print:text-gray-600">Remaining</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-center print:text-gray-600">Status</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider print:text-gray-600">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700 print:divide-gray-200">
                    @forelse($recentFees as $fee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors print:hover:bg-transparent">
                        <td class="px-5 py-3">
                            <p class="font-medium text-gray-900 dark:text-slate-100 print:text-gray-900">{{ $fee->student->name ?? '—' }}</p>
                            <p class="text-xs text-gray-500 dark:text-slate-500 print:text-gray-500">{{ $fee->student->roll_number ?? '' }}</p>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300 print:text-gray-700">{{ $fee->student->class_name ?? '—' }}{{ $fee->student->section ? '-' . $fee->student->section : '' }}</td>
                        <td class="px-5 py-3 text-right font-medium text-gray-900 dark:text-white print:text-gray-900">${{ number_format($fee->amount, 2) }}</td>
                        <td class="px-5 py-3 text-right font-medium text-emerald-600 dark:text-emerald-400 print:text-gray-800">${{ number_format($fee->paid_amount ?? 0, 2) }}</td>
                        <td class="px-5 py-3 text-right font-medium text-gray-900 dark:text-white print:text-gray-900">${{ number_format($fee->pending_amount, 2) }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-medium {{ $fee->status === 'PAID' ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : ($fee->status === 'PENDING' ? 'bg-amber-500/20 text-amber-600 dark:text-amber-400' : 'bg-cyan-500/20 text-cyan-600 dark:text-cyan-400') }} print:bg-gray-100 print:text-gray-800">{{ $fee->status_label }}</span>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-500 dark:text-slate-400 print:text-gray-600">{{ $fee->paid_date ? $fee->paid_date->format('M j, Y') : '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-8 text-center text-gray-500 dark:text-slate-500 print:text-gray-500">No recent fee collections.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    var isDark = document.documentElement.classList.contains('dark');
    var gridColor = isDark ? 'rgba(148, 163, 184, 0.2)' : 'rgba(0, 0, 0, 0.08)';
    var textColor = isDark ? '#94a3b8' : '#64748b';

    var chartFeeStatus = {
        labels: @json($chartFeeStatus['labels'] ?? []),
        data: @json($chartFeeStatus['data'] ?? []),
        colors: @json($chartFeeStatus['colors'] ?? ['#10b981', '#f59e0b', '#06b6d4'])
    };
    var chartRevenueByClass = {
        labels: @json($chartRevenueByClass['labels'] ?? []),
        data: @json($chartRevenueByClass['data'] ?? [])
    };
    var chartRevenueByMonth = {
        labels: @json($chartRevenueByMonth['labels'] ?? []),
        data: @json($chartRevenueByMonth['data'] ?? [])
    };

    if (document.getElementById('chart-fee-status') && chartFeeStatus.labels.length) {
        new Chart(document.getElementById('chart-fee-status'), {
            type: 'pie',
            data: {
                labels: chartFeeStatus.labels,
                datasets: [{
                    data: chartFeeStatus.data,
                    backgroundColor: chartFeeStatus.colors,
                    borderWidth: 1,
                    borderColor: isDark ? '#334155' : '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: textColor, padding: 16 } }
                }
            }
        });
    }

    if (document.getElementById('chart-revenue-by-class') && chartRevenueByClass.labels.length) {
        new Chart(document.getElementById('chart-revenue-by-class'), {
            type: 'bar',
            data: {
                labels: chartRevenueByClass.labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: chartRevenueByClass.data,
                    backgroundColor: 'rgba(6, 182, 212, 0.7)',
                    borderColor: 'rgb(6, 182, 212)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    x: {
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: function(ctx) { return '$' + Number(ctx.raw).toLocaleString(); } } }
                }
            }
        });
    }

    if (document.getElementById('chart-revenue-by-month') && chartRevenueByMonth.labels.length) {
        new Chart(document.getElementById('chart-revenue-by-month'), {
            type: 'bar',
            data: {
                labels: chartRevenueByMonth.labels,
                datasets: [{
                    label: 'Revenue ($)',
                    data: chartRevenueByMonth.data,
                    backgroundColor: 'rgba(139, 92, 246, 0.7)',
                    borderColor: 'rgb(139, 92, 246)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    },
                    x: {
                        grid: { color: gridColor },
                        ticks: { color: textColor }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: function(ctx) { return '$' + Number(ctx.raw).toLocaleString(); } } }
                }
            }
        });
    }
})();
</script>
@endsection
