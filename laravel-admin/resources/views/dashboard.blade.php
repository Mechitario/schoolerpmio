@extends('layouts.app')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <h1 class="text-gray-900 dark:text-white">Dashboard</h1>
        <div class="flex gap-2">
            @php
                $exportParams = array_filter([
                    'report_type' => request('report_type'),
                    'report_year' => request('report_year'),
                    'report_month' => request('report_month'),
                ]);
            @endphp
            <a href="{{ route('admin.dashboard.export', $exportParams) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-cyan-500/50 transition-all">
                Export
            </a>
            <a href="{{ route('admin.dashboard.report', $exportParams) }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-gradient-to-r from-cyan-500 to-violet-600 text-white hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                Generate Report
            </a>
        </div>
    </div>

    {{-- Report period: Yearly / Monthly --}}
    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 shadow-sm dark:shadow-none">
        <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-300 mb-4">Report period</h3>
        <form method="get" action="{{ route('admin.dashboard') }}" id="report-period-form" class="flex flex-wrap items-end gap-4">
            <input type="hidden" name="list_class" value="{{ request('list_class') }}">
            <input type="hidden" name="list_status" value="{{ request('list_status') }}">
            <div class="flex items-center gap-2">
                <label for="report_type" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Type</label>
                <select name="report_type" id="report_type" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="yearly" {{ ($reportType ?? '') === 'yearly' ? 'selected' : '' }}>Yearly report</option>
                    <option value="monthly" {{ ($reportType ?? '') === 'monthly' ? 'selected' : '' }}>Monthly report</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <label for="report_year" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Year</label>
                <select name="report_year" id="report_year" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">—</option>
                    @foreach($filterYears ?? [] as $y)
                        <option value="{{ $y }}" {{ (string)($reportYear ?? '') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            @if(($reportType ?? '') === 'monthly')
            <div class="flex items-center gap-2" id="report-month-wrap">
                <label for="report_month" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Month</label>
                <select name="report_month" id="report_month" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">—</option>
                    @foreach($filterMonths ?? [] as $label => $value)
                        <option value="{{ $value }}" {{ (string)($reportMonth ?? '') === (string)$value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </form>
        <p class="text-xs text-gray-500 dark:text-slate-400 mt-3">
            @if(($reportType ?? '') === 'monthly' && !empty($reportMonth))
                Showing data for <strong>{{ $reportMonth }}</strong>
            @elseif(!empty($reportYear))
                Showing data for year <strong>{{ $reportYear }}</strong>
            @else
                Select a year (and month for monthly report) to filter stats and fee list.
            @endif
        </p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 hover:border-cyan-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="flex items-center justify-between">
                <div class="p-2.5 rounded-xl bg-cyan-500/20 text-cyan-600 dark:text-cyan-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">+12%</span>
            </div>
            <p class="mt-3 text-xl font-bold text-gray-900 dark:text-white">{{ number_format($studentCount) }}</p>
            <p class="text-sm text-gray-500 dark:text-slate-400">Total Students</p>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 hover:border-violet-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="flex items-center justify-between">
                <div class="p-2.5 rounded-xl bg-violet-500/20 text-violet-600 dark:text-violet-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">+2</span>
            </div>
            <p class="mt-3 text-xl font-bold text-gray-900 dark:text-white">{{ number_format($staffCount) }}</p>
            <p class="text-sm text-gray-500 dark:text-slate-400">Active Staff</p>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 hover:border-emerald-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="flex items-center justify-between">
                <div class="p-2.5 rounded-xl bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400">+5.4%</span>
            </div>
            <p class="mt-3 text-xl font-bold text-gray-900 dark:text-white">${{ number_format($monthlyRevenue) }}</p>
            <p class="text-sm text-gray-500 dark:text-slate-400">{{ ($reportType ?? '') === 'monthly' && !empty($reportMonth) ? 'Revenue (Month)' : 'Revenue (Year)' }}</p>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 hover:border-rose-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="flex items-center justify-between">
                <div class="p-2.5 rounded-xl bg-rose-500/20 text-rose-600 dark:text-rose-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                </div>
                <span class="text-xs font-medium text-rose-600 dark:text-rose-400">-2.1%</span>
            </div>
            <p class="mt-3 text-xl font-bold text-gray-900 dark:text-white">${{ number_format($pendingFees) }}</p>
            <p class="text-sm text-gray-500 dark:text-slate-400">{{ ($reportType ?? '') === 'monthly' && !empty($reportMonth) ? 'Pending (Month)' : 'Pending (Year)' }}</p>
        </div>
    </div>

    {{-- Recent Fee Collections --}}
    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm dark:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between bg-gray-50 dark:bg-slate-800/50">
            <div>
                <h3 class="text-gray-900 dark:text-white">Recent Fee Collections</h3>
                <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5">Latest transactions</p>
            </div>
            <a href="{{ route('admin.fees.index') }}" class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 flex items-center gap-1 transition-colors">
                View all
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        {{-- List filter bar --}}
        <form method="get" action="{{ route('admin.dashboard') }}" class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 flex flex-wrap items-center gap-3 bg-white dark:bg-slate-800/80">
            @if(request('report_type'))<input type="hidden" name="report_type" value="{{ request('report_type') }}">@endif
            @if(request('report_year'))<input type="hidden" name="report_year" value="{{ request('report_year') }}">@endif
            @if(request('report_month'))<input type="hidden" name="report_month" value="{{ request('report_month') }}">@endif
            <span class="text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Filter list:</span>
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label for="list_class" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Class</label>
                    <select name="list_class" id="list_class" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        <option value="">All classes</option>
                        @foreach($filterClasses ?? [] as $c)
                            <option value="{{ $c }}" {{ request('list_class') === (string)$c ? 'selected' : '' }}>Class {{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <label for="list_status" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Status</label>
                    <select name="list_status" id="list_status" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        <option value="">All</option>
                        <option value="PAID" {{ request('list_status') === 'PAID' ? 'selected' : '' }}>Paid</option>
                        <option value="PENDING" {{ request('list_status') === 'PENDING' ? 'selected' : '' }}>Pending</option>
                        <option value="PARTIAL" {{ request('list_status') === 'PARTIAL' ? 'selected' : '' }}>Partial</option>
                    </select>
                </div>
            </div>
            @if(request('list_class') || request('list_status'))
            <a href="{{ route('admin.dashboard', array_filter(['report_type' => request('report_type'), 'report_year' => request('report_year'), 'report_month' => request('report_month')])) }}" class="text-sm text-gray-500 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">Clear list filters</a>
            @endif
        </form>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Student</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Class</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Total amount</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Paid amount</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-center">Status</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Remaining to pay</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($recentFees as $fee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($fee->student->name ?? 'N/A') }}&size=80&background=06b6d4&color=fff" alt="" class="w-9 h-9 rounded-lg object-cover ring-2 ring-gray-200 dark:ring-slate-600">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-slate-100">{{ $fee->student->name ?? '—' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-500">{{ $fee->student->roll_number ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $fee->student->class_name ?? '—' }}{{ $fee->student->section ? '-' . $fee->student->section : '' }}</td>
                        <td class="px-5 py-3 text-right font-medium text-gray-900 dark:text-white">${{ number_format($fee->amount, 2) }}</td>
                        <td class="px-5 py-3 text-right font-medium {{ $fee->paid_amount > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-slate-400' }}">
                            ${{ number_format($fee->paid_amount ?? 0, 2) }}
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-medium {{ $fee->status === 'PAID' ? 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400' : ($fee->status === 'PENDING' ? 'bg-amber-500/20 text-amber-600 dark:text-amber-400' : 'bg-cyan-500/20 text-cyan-600 dark:text-cyan-400') }}">
                                {{ $fee->status_label }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-right font-medium {{ $fee->pending_amount > 0 ? 'text-amber-600 dark:text-amber-400' : 'text-gray-500 dark:text-slate-400' }}">
                            ${{ number_format($fee->pending_amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm text-gray-500 dark:text-slate-500">No recent fee collections.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-slate-400">Showing last {{ $recentFees->count() }} transactions</p>
            <a href="{{ route('admin.fees.index') }}" class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">View full history</a>
        </div>
    </div>
</div>
@endsection
