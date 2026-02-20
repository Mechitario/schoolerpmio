@extends('layouts.app')

@section('title', 'Fee Tracking')
@section('breadcrumb', 'Fee Tracking')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-gray-900 dark:text-white">Fee Management</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-1">Track and record student fee payments.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Export
            </button>
            <a href="{{ route('admin.fees.import') }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Bulk import (CSV)
            </a>
            <a href="{{ route('admin.fees.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                Record Payment
            </a>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-emerald-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Paid this month</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($paidThisMonth) }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-rose-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-rose-500/20 flex items-center justify-center text-rose-600 dark:text-rose-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Pending</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">${{ number_format($pendingTotal) }}</p>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl p-5 flex items-center gap-4 hover:border-cyan-500/30 transition-colors shadow-sm dark:shadow-none">
            <div class="w-12 h-12 rounded-xl bg-cyan-500/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase">Collection rate</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">
                    @php
                        $total = $paidThisMonth + $pendingTotal;
                        $rate = $total > 0 ? round(($paidThisMonth / $total) * 100) : 0;
                    @endphp
                    {{ $rate }}%
                </p>
            </div>
        </div>
    </div>

    <form method="get" action="{{ route('admin.fees.index') }}" class="bg-white dark:bg-slate-800/80 p-4 rounded-xl border border-gray-200 dark:border-slate-700 flex flex-col md:flex-row gap-4 shadow-sm dark:shadow-none">
        <div class="flex items-center gap-2">
            <label for="filter_year" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Year</label>
            <select name="year" id="filter_year" onchange="this.form.submit();" class="bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2.5 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <option value="">All years</option>
                @foreach($filterYears ?? [] as $y)
                    <option value="{{ $y }}" {{ (string)request('year') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2 min-w-[140px]">
            <label for="filter_month" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Month</label>
            <select name="month" id="filter_month" onchange="this.form.submit();" class="flex-1 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2.5 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <option value="">All months</option>
                @foreach($filterMonths ?? [] as $value => $label)
                    <option value="{{ $value }}" {{ request('month') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-center gap-2 min-w-[140px]">
            <label for="filter_status" class="text-sm text-gray-600 dark:text-slate-400 whitespace-nowrap">Status</label>
            <select name="status" id="filter_status" onchange="this.form.submit();" class="flex-1 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-3 py-2.5 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <option value="">All statuses</option>
                <option value="PAID" {{ request('status') === 'PAID' ? 'selected' : '' }}>Fully paid</option>
                <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Pending</option>
                <option value="PARTIAL" {{ request('status') === 'PARTIAL' ? 'selected' : '' }}>Partial</option>
            </select>
        </div>
        <div class="relative flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by student name or roll number..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
            <svg class="w-5 h-5 text-gray-400 dark:text-slate-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <button type="submit" class="px-4 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-slate-200 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">Search</button>
    </form>

    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex items-center justify-between">
            <h2 class="text-gray-900 dark:text-white">Fee Records</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Roll No.</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Student</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Parent</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Class / Section</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Month</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-center">Fee Items</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Total</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Received</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Waived</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Pending</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">B/C</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($fees as $fee)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3 font-medium text-cyan-600 dark:text-cyan-400">#{{ $fee->student ? $fee->student->roll_number : '—' }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($fee->student ? $fee->student->name : 'N/A') }}&background=06b6d4&color=fff" alt="" class="w-8 h-8 rounded-lg object-cover ring-2 ring-gray-200 dark:ring-slate-600">
                                <span class="font-medium text-gray-900 dark:text-slate-100">{{ $fee->student ? $fee->student->name : '—' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">
                            @if($fee->parent)
                                {{ $fee->parent->name }}
                                @if($fee->parent->phone)
                                    <span class="text-xs text-gray-500 dark:text-slate-500 block">{{ $fee->parent->phone }}</span>
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">
                            @if($fee->student)
                                {{ $fee->student->class_name ?? '—' }}{{ $fee->student->section ? ' / ' . $fee->student->section : '' }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $fee->month }}</td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">
                            @if($fee->payment_date)
                                {{ $fee->payment_date->format('M d, Y') }}
                            @elseif($fee->paid_date)
                                {{ $fee->paid_date->format('M d, Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-5 py-3 text-center">
                            @if((($fee->copy_fee ?? 0) + ($fee->dress_fee ?? 0) + ($fee->book_fee ?? 0) + ($fee->exam_fee ?? 0)) > 0)
                                <button 
                                    type="button"
                                    onclick="showFeeItemsModal({{ $fee->id }}, {{ $fee->copy_fee ?? 0 }}, {{ $fee->dress_fee ?? 0 }}, {{ $fee->book_fee ?? 0 }}, {{ $fee->exam_fee ?? 0 }}, {{ $fee->amount }})"
                                    class="text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 hover:underline cursor-pointer text-sm font-medium transition-colors"
                                >
                                    View
                                </button>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right font-bold text-gray-900 dark:text-white">${{ number_format($fee->amount, 2) }}</td>
                        @php
                            $received = $fee->received_amount ?? $fee->paid_amount ?? 0;
                            $waived = $fee->waived_off ?? 0;
                            $pending = $fee->pending_amount;
                            $receivedClass = $received > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-slate-400';
                            $pendingClass = $pending > 0 ? 'text-amber-600 dark:text-amber-400 font-semibold' : 'text-gray-500 dark:text-slate-400';
                        @endphp
                        <td class="px-5 py-3 text-right font-medium {{ $receivedClass }}">${{ number_format($received, 2) }}</td>
                        <td class="px-5 py-3 text-right text-sm text-gray-600 dark:text-slate-400">${{ number_format($waived, 2) }}</td>
                        <td class="px-5 py-3 text-right font-medium {{ $pendingClass }}">${{ number_format($pending, 2) }}</td>
                        <td class="px-5 py-3 text-right text-sm text-gray-600 dark:text-slate-400">${{ number_format($fee->balance_carried_forward ?? 0, 2) }}</td>
                        <td class="px-5 py-3">
                            @php
                                $statusClass = 'bg-cyan-500/20 text-cyan-600 dark:text-cyan-400';
                                if ($fee->status === 'PAID') {
                                    $statusClass = 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400';
                                } elseif ($fee->status === 'PENDING') {
                                    $statusClass = 'bg-rose-500/20 text-rose-600 dark:text-rose-400';
                                }
                            @endphp
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg {{ $statusClass }}">{{ $fee->status_label }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.fees.edit', $fee) }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Edit fee record">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="14" class="px-5 py-12 text-center text-gray-500 dark:text-slate-500">
                            <p class="font-medium">No fee records found</p>
                            <p class="text-sm mt-1">Try a different search or record a payment.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fees->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-slate-400">Showing {{ $fees->firstItem() }}–{{ $fees->lastItem() }} of {{ $fees->total() }}</p>
            <div class="flex gap-2">
                @if($fees->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Previous</span>
                @else
                <a href="{{ $fees->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Previous</a>
                @endif
                @if($fees->hasMorePages())
                <a href="{{ $fees->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Next</a>
                @else
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Fee Items Modal -->
<div id="feeItemsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-xl max-w-md w-full mx-4 border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Fee Items Breakdown</h3>
            <button onclick="closeFeeItemsModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-slate-700">
                    <span class="text-gray-600 dark:text-slate-400">Copy Fee</span>
                    <span class="font-medium text-gray-900 dark:text-white">$<span id="modal-copy-fee">0.00</span></span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-slate-700">
                    <span class="text-gray-600 dark:text-slate-400">Dress Fee</span>
                    <span class="font-medium text-gray-900 dark:text-white">$<span id="modal-dress-fee">0.00</span></span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-slate-700">
                    <span class="text-gray-600 dark:text-slate-400">Book Fee</span>
                    <span class="font-medium text-gray-900 dark:text-white">$<span id="modal-book-fee">0.00</span></span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-200 dark:border-slate-700">
                    <span class="text-gray-600 dark:text-slate-400">Exam Fee</span>
                    <span class="font-medium text-gray-900 dark:text-white">$<span id="modal-exam-fee">0.00</span></span>
                </div>
                <div class="flex justify-between items-center pt-3">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Total</span>
                    <span class="text-lg font-bold text-cyan-600 dark:text-cyan-400">$<span id="modal-total">0.00</span></span>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 flex justify-end">
            <button onclick="closeFeeItemsModal()" class="px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-slate-200 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<script>
function showFeeItemsModal(feeId, copyFee, dressFee, bookFee, examFee, total) {
    document.getElementById('modal-copy-fee').textContent = parseFloat(copyFee).toFixed(2);
    document.getElementById('modal-dress-fee').textContent = parseFloat(dressFee).toFixed(2);
    document.getElementById('modal-book-fee').textContent = parseFloat(bookFee).toFixed(2);
    document.getElementById('modal-exam-fee').textContent = parseFloat(examFee).toFixed(2);
    document.getElementById('modal-total').textContent = parseFloat(total).toFixed(2);
    
    const modal = document.getElementById('feeItemsModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeFeeItemsModal() {
    const modal = document.getElementById('feeItemsModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Close modal when clicking outside
document.getElementById('feeItemsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFeeItemsModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('feeItemsModal');
        if (!modal.classList.contains('hidden')) {
            closeFeeItemsModal();
        }
    }
});
</script>
@endsection
