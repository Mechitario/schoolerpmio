@extends('layouts.app')

@section('title', 'Staff')
@section('breadcrumb', 'Staff & Teachers')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-gray-900 dark:text-white">Staff Management</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-1">Manage teachers, administrators, and staff salaries.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.staff.salaries') }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Pay Salaries
            </a>
            <a href="{{ route('admin.staff.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                Add Staff
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-cyan-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Total Staff</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $staff->total() }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-emerald-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Teaching</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $teachingCount }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-violet-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-violet-500/20 flex items-center justify-center text-violet-600 dark:text-violet-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Admin / Other</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $adminCount }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-rose-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-600 dark:text-rose-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Monthly Payout</p>
                <p class="text-xl font-bold text-rose-600 dark:text-rose-400">${{ number_format($totalSalary) }}</p>
            </div>
        </div>
    </div>

    <form method="get" action="{{ route('admin.staff.index') }}" class="bg-white dark:bg-slate-800/80 p-4 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm dark:shadow-none">
        @if(request('year'))<input type="hidden" name="year" value="{{ request('year') }}">@endif
        @if(request('payment_year'))<input type="hidden" name="payment_year" value="{{ request('payment_year') }}">@endif
        @if(request('salary_year'))<input type="hidden" name="salary_year" value="{{ request('salary_year') }}">@endif
        <div class="relative max-w-md flex gap-2 flex-wrap">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or role..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <svg class="w-5 h-5 text-gray-400 dark:text-slate-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-4 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-slate-200 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">Search</button>
        </div>
    </form>

    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Staff</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Salary</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($staff as $member)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-gray-500 dark:text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-slate-100">{{ $member->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-500">—</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3 font-medium text-gray-700 dark:text-slate-300">{{ $member->role }}</td>
                        <td class="px-5 py-3 text-right font-bold text-gray-900 dark:text-white">${{ number_format($member->salary, 2) }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">Active</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.staff.edit', $member) }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 bg-gray-100 dark:bg-slate-700 hover:bg-cyan-500/20 hover:text-cyan-600 dark:hover:text-cyan-400 rounded-lg transition-colors">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-500 dark:text-slate-500">
                            <p class="font-medium">No staff found</p>
                            <p class="text-sm mt-1">Try a different search or add new staff.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($staff->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-slate-400">Showing {{ $staff->firstItem() }}–{{ $staff->lastItem() }} of {{ $staff->total() }}</p>
            <div class="flex gap-2">
                @if($staff->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Previous</span>
                @else
                <a href="{{ $staff->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Previous</a>
                @endif
                @if($staff->hasMorePages())
                <a href="{{ $staff->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Next</a>
                @else
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Past salary payments --}}
    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-gray-900 dark:text-white">Past salary payments</h2>
            <form method="get" action="{{ route('admin.staff.index') }}" class="flex items-center gap-2 flex-wrap">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('year'))<input type="hidden" name="year" value="{{ request('year') }}">@endif
                @if(request('salary_year'))<input type="hidden" name="salary_year" value="{{ request('salary_year') }}">@endif
                <label for="payment_year" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Year</label>
                <select name="payment_year" id="payment_year" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">All years</option>
                    @foreach($filterYears ?? [] as $y)
                        <option value="{{ $y }}" {{ (string)($paymentYear ?? '') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <a href="{{ route('admin.staff.salaries') }}" class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">Record payment</a>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Staff</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Month</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Amount</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Date paid</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($recentPayments ?? [] as $pay)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-slate-100">{{ $pay->staff->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $pay->month }}</td>
                        <td class="px-5 py-3 text-right font-medium text-gray-900 dark:text-white">${{ number_format($pay->amount, 2) }}</td>
                        <td class="px-5 py-3 text-sm text-gray-500 dark:text-slate-400">{{ $pay->paid_date ? $pay->paid_date->format('M d, Y') : '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-500 dark:text-slate-500">No salary payments recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Salary status (paid vs due) by staff --}}
    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex flex-wrap items-center justify-between gap-4">
            <h2 class="text-gray-900 dark:text-white">Salary status (paid / due) by staff</h2>
            <form method="get" action="{{ route('admin.staff.index') }}" class="flex items-center gap-2 flex-wrap">
                @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
                @if(request('year'))<input type="hidden" name="year" value="{{ request('year') }}">@endif
                @if(request('payment_year'))<input type="hidden" name="payment_year" value="{{ request('payment_year') }}">@endif
                <label for="salary_year" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Year</label>
                <select name="salary_year" id="salary_year" onchange="this.form.submit();" class="text-sm bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    @foreach($filterYears ?? [] as $y)
                        <option value="{{ $y }}" {{ (string)($salaryYear ?? '') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Staff</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Monthly salary</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Paid months</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Due months</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($salaryStatus ?? [] as $row)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-slate-100">{{ $row['staff']->name }}</td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $row['staff']->role }}</td>
                        <td class="px-5 py-3 text-right font-medium text-gray-900 dark:text-white">${{ number_format($row['staff']->salary, 2) }}</td>
                        <td class="px-5 py-3 text-sm">
                            @if(count($row['paid_months']) > 0)
                                <span class="text-emerald-600 dark:text-emerald-400 font-medium">{{ count($row['paid_months']) }} paid</span>
                                <span class="text-gray-500 dark:text-slate-400">— {{ implode(', ', $row['paid_months']) }}</span>
                            @else
                                <span class="text-gray-500 dark:text-slate-500">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm">
                            @if(count($row['due_months']) > 0)
                                <span class="text-amber-600 dark:text-amber-400 font-medium">{{ count($row['due_months']) }} due</span>
                                <span class="text-gray-500 dark:text-slate-400">— {{ implode(', ', $row['due_months']) }}</span>
                            @else
                                <span class="text-emerald-600 dark:text-emerald-400">All paid</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-500 dark:text-slate-500">No staff found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
