@extends('layouts.app')

@section('title', 'Bulk Upload Marks')
@section('breadcrumb', 'Bulk Upload Marks')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('admin.academics.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Exam Results
        </a>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-2">Bulk upload marks (subject-wise)</h2>
        <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">
            Upload a CSV file to add or update exam marks for multiple students. Use the template below and save as CSV from Excel.
        </p>

        <div class="mb-6 p-4 rounded-lg bg-slate-800 dark:bg-slate-900 border border-slate-700 dark:border-slate-600 text-sm text-slate-300">
            <p class="font-semibold text-slate-200 mb-2">Instructions</p>
            <p class="mb-2">CSV must have a header row with these exact column names:</p>
            <div class="font-mono text-slate-100 bg-slate-700/50 rounded px-3 py-2 border border-slate-600 mb-2 text-xs">
                roll_number, exam_name, subject, marks, total_marks
            </div>
            <ul class="space-y-1 text-slate-300 list-disc list-inside text-xs">
                <li><strong class="text-slate-200">roll_number</strong> — student roll (must exist)</li>
                <li><strong class="text-slate-200">exam_name</strong> — e.g. Mid-Term 2025</li>
                <li><strong class="text-slate-200">subject</strong> — e.g. Mathematics, Science</li>
                <li><strong class="text-slate-200">marks</strong> — marks obtained</li>
                <li><strong class="text-slate-200">total_marks</strong> — max marks for that subject</li>
            </ul>
            <p class="mt-2 text-slate-400 text-xs">One row per student per subject per exam. Matching rows are updated.</p>
        </div>

        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('admin.academics.import.template') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download template (CSV)
            </a>
        </div>

        <form method="POST" action="{{ route('admin.academics.import.process') }}" enctype="multipart/form-data" class="space-y-4">
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
                <a href="{{ route('admin.academics.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Record marks (individual)
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
