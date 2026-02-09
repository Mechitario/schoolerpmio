@extends('layouts.app')

@section('title', 'Bulk Import Fees')
@section('breadcrumb', 'Bulk Import')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.fees.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Fee Tracking
        </a>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-2">Bulk import / update via Excel (CSV)</h2>
        <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">
            Upload a CSV file to add or update fee records in bulk. Use the template below and save as CSV from Excel.
        </p>

        <div class="mb-6 p-4 rounded-lg bg-gray-50 dark:bg-slate-700/30 border border-gray-200 dark:border-slate-600">
            <p class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">CSV format (first row = headers):</p>
            <code class="text-xs text-gray-600 dark:text-slate-400 block">roll_number,month,amount,paid_amount</code>
            <ul class="mt-2 text-xs text-gray-600 dark:text-slate-400 space-y-1 list-disc list-inside">
                <li><strong>roll_number</strong> — Student roll number (must exist)</li>
                <li><strong>month</strong> — e.g. January 2025, February 2025</li>
                <li><strong>amount</strong> — Total fee amount (number)</li>
                <li><strong>paid_amount</strong> — Amount paid so far (0 = Pending, amount = Fully paid, in between = Partial). Optional: use <strong>status</strong> (PAID or PENDING) instead for backward compatibility.</li>
            </ul>
            <p class="mt-2 text-xs text-gray-500 dark:text-slate-500">
                If a fee record already exists for the same student + month, it will be updated. Otherwise a new record is created.
            </p>
        </div>

        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('admin.fees.import.template') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download template (CSV)
            </a>
        </div>

        <form method="POST" action="{{ route('admin.fees.import.process') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Select CSV file <span class="text-rose-500">*</span></label>
                <input type="file" name="file" id="file" accept=".csv,.txt" required
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-500/20 file:text-cyan-600 dark:file:text-cyan-400 file:font-medium focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-500">From Excel: File → Save As → CSV (Comma delimited). Max 2 MB.</p>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Upload and import
                </button>
                <a href="{{ route('admin.fees.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Record single payment instead
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
