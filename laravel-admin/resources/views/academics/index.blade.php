@extends('layouts.app')

@section('title', 'Exam Results')
@section('breadcrumb', 'Exam Results')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="p-3 rounded-lg bg-amber-500/20 border border-amber-500/30 text-amber-700 dark:text-amber-300 text-sm">
            {{ session('warning') }}
        </div>
    @endif
    @if (session('error'))
        <div class="p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
            {{ session('error') }}
        </div>
    @endif
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-gray-900 dark:text-white">Academics & Reports</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-1">Manage exam marks and generate student report cards.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('admin.academics.create') }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Record marks (individual)
            </a>
            <a href="{{ route('admin.academics.import') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                Bulk upload marks
            </a>
            <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Export All
            </button>
        </div>
    </header>

    <div class="flex gap-2 overflow-x-auto pb-2">
        @foreach($examTypes as $exam)
        <a href="{{ route('admin.academics.index', array_filter(['exam' => $exam, 'year' => request('year')])) }}" class="px-4 py-2 rounded-xl text-sm font-medium whitespace-nowrap transition-all {{ request('exam') === $exam ? 'bg-gradient-to-r from-cyan-500 to-violet-600 text-white shadow-lg shadow-cyan-500/20' : 'bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 hover:border-cyan-500/50 shadow-sm dark:shadow-none' }}">
            {{ $exam }}
        </a>
        @endforeach
        @if($examTypes->isEmpty())
        <span class="px-4 py-2 rounded-xl text-sm font-medium bg-gradient-to-r from-cyan-500 to-violet-600 text-white">All Results</span>
        @endif
    </div>

    <form method="get" action="{{ route('admin.academics.index') }}" class="bg-white dark:bg-slate-800/80 p-4 rounded-xl border border-gray-200 dark:border-slate-700 shadow-sm dark:shadow-none">
        @if(request('exam'))
        <input type="hidden" name="exam" value="{{ request('exam') }}">
        @endif
        @if(request('year'))
        <input type="hidden" name="year" value="{{ request('year') }}">
        @endif
        <div class="relative max-w-md flex gap-2 flex-wrap">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or roll number..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <svg class="w-5 h-5 text-gray-400 dark:text-slate-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <button type="submit" class="px-4 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-slate-200 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">Search</button>
        </div>
    </form>

    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
            <h2 class="text-gray-900 dark:text-white">{{ request('exam', 'All') }} — Result Overview</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Roll No.</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Student</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Subject</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Class</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Marks</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">%</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Grade</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Report</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($results as $result)
                    @php
                        $percentage = $result->percentage;
                        $grade = $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B+' : 'B'));
                        $gradeClass = match(true) {
                            $grade === 'A+' => 'bg-emerald-500/20 text-emerald-600 dark:text-emerald-400',
                            $grade === 'A' => 'bg-emerald-500/10 text-emerald-700 dark:text-emerald-300',
                            str_starts_with($grade, 'B') => 'bg-cyan-500/20 text-cyan-600 dark:text-cyan-400',
                            default => 'bg-gray-200 dark:bg-slate-600 text-gray-700 dark:text-slate-300',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3 font-medium text-cyan-600 dark:text-cyan-400">#{{ $result->student->roll_number ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($result->student->name ?? 'N/A') }}&background=8b5cf6&color=fff" alt="" class="w-8 h-8 rounded-lg object-cover ring-2 ring-gray-200 dark:ring-slate-600">
                                <span class="font-medium text-gray-900 dark:text-slate-100">{{ $result->student->name ?? '—' }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $result->subject }}</td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $result->student->class_name ?? '—' }}{{ $result->student->section ? ' / ' . $result->student->section : '' }}</td>
                        <td class="px-5 py-3 text-right font-bold text-gray-900 dark:text-white">{{ $result->marks }}/{{ $result->total_marks }}</td>
                        <td class="px-5 py-3 text-right font-bold text-gray-900 dark:text-white">{{ number_format($percentage, 1) }}%</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex text-xs font-bold px-2.5 py-1 rounded-lg {{ $gradeClass }}">{{ $grade }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.academics.report', $result) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">Download</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center text-gray-500 dark:text-slate-500">
                            <p class="font-medium">No results found</p>
                            <p class="text-sm mt-1">Try a different search or exam type, or upload marks.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($results->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-slate-400">Showing {{ $results->firstItem() }}–{{ $results->lastItem() }} of {{ $results->total() }}</p>
            <div class="flex gap-2">
                @if($results->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Previous</span>
                @else
                <a href="{{ $results->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Previous</a>
                @endif
                @if($results->hasMorePages())
                <a href="{{ $results->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Next</a>
                @else
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
