@extends('layouts.app')

@section('title', 'Record Payment')
@section('breadcrumb', 'Record Payment')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.fees.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Fee Tracking
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Record Fee Payment</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.fees.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Student <span class="text-rose-500">*</span></label>
                <select name="student_id" id="student_id" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">Select student</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} — #{{ $s->roll_number }} ({{ $s->class_name }}{{ $s->section ? ' ' . $s->section : '' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Month <span class="text-rose-500">*</span></label>
                <select name="month" id="month" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    @foreach($months as $value => $label)
                        <option value="{{ $value }}" {{ old('month') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Total amount ($) <span class="text-rose-500">*</span></label>
                <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" step="0.01"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="0.00">
            </div>
            <div>
                <label for="paid_amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Paid amount ($)</label>
                <input type="number" name="paid_amount" id="paid_amount" value="{{ old('paid_amount', '0') }}" min="0" step="0.01"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="0.00">
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-500">Amount paid so far. Status: 0 = Pending, full amount = Fully paid, in between = Partial.</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Record Payment
                </button>
                <a href="{{ route('admin.fees.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <div class="mt-8 p-4 rounded-xl border border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
        <h3 class="text-gray-700 dark:text-slate-300 mb-2">Bulk import / update</h3>
        <p class="text-sm text-gray-500 dark:text-slate-400 mb-3">Add or update many fee records at once using a CSV file (save as CSV from Excel).</p>
        <a href="{{ route('admin.fees.import') }}" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 border border-cyan-500/30 rounded-lg hover:bg-cyan-500/10 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
            Import or update in bulk via Excel (CSV)
        </a>
    </div>
</div>
@endsection
