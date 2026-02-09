@extends('layouts.app')

@section('title', 'Students')
@section('breadcrumb', 'Students')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h1 class="text-gray-900 dark:text-white">Student Directory</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-1">Manage and monitor student records across all classes.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('admin.students.export', request()->only(['search', 'class', 'year'])) }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Export List
            </a>
            <a href="{{ route('admin.students.import') }}" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                Bulk import (CSV)
            </a>
            <a href="{{ route('admin.students.create') }}" class="flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                Add Student
            </a>
        </div>
    </header>

    <form method="get" action="{{ route('admin.students.index') }}" class="bg-white dark:bg-slate-800/80 p-4 rounded-xl border border-gray-200 dark:border-slate-700 flex flex-col md:flex-row gap-4 shadow-sm dark:shadow-none flex-wrap">
        <div class="relative flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, roll number..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
            <svg class="w-5 h-5 text-gray-400 dark:text-slate-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <select name="year" class="min-w-[140px] bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 transition-colors" title="Filter by batch/year added">
            <option value="">All years</option>
            @foreach(range((int) date('Y') + 1, (int) date('Y') - 15) as $y)
                <option value="{{ $y }}" {{ request('year') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        <select name="class" class="min-w-[160px] bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2.5 text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 transition-colors">
            <option value="All" {{ request('class') === 'All' ? 'selected' : '' }}>All Classes</option>
            @foreach(range(1, 12) as $n)
                <option value="{{ $n }}" {{ request('class') === (string)$n ? 'selected' : '' }}>Class {{ $n }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2.5 bg-gray-200 dark:bg-slate-700 text-gray-800 dark:text-slate-200 font-medium rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">Search</button>
    </form>

    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Student</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Roll No.</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Class / Section</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Year</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=06b6d4&color=fff" alt="" class="w-10 h-10 rounded-lg object-cover ring-2 ring-gray-200 dark:ring-slate-600">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-slate-100">{{ $student->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-slate-500">—</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3"><span class="bg-cyan-500/10 dark:bg-slate-700 px-2.5 py-1 rounded-lg text-sm font-medium text-cyan-600 dark:text-cyan-400">#{{ $student->roll_number }}</span></td>
                        <td class="px-5 py-3">
                            <span class="font-medium text-gray-800 dark:text-slate-200">{{ $student->class_name }}</span>
                            @if($student->section)
                            <span class="ml-1.5 px-2 py-0.5 bg-violet-500/20 text-violet-600 dark:text-violet-400 rounded text-xs font-medium">{{ $student->section }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $student->year ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">Active</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.students.edit', $student) }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 hover:text-cyan-600 dark:hover:text-cyan-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg transition-colors" title="Edit student">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-500 dark:text-slate-500">
                            <p class="font-medium">No students found</p>
                            <p class="text-sm mt-1">Try adjusting your filters or add a new student.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
        <div class="px-5 py-3 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex items-center justify-between">
            <p class="text-sm text-gray-500 dark:text-slate-400">Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }}</p>
            <div class="flex gap-2">
                @if($students->onFirstPage())
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Previous</span>
                @else
                <a href="{{ $students->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Previous</a>
                @endif
                @if($students->hasMorePages())
                <a href="{{ $students->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-slate-300 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">Next</a>
                @else
                <span class="px-4 py-2 text-sm text-gray-400 dark:text-slate-500 border border-gray-300 dark:border-slate-600 rounded-lg cursor-not-allowed">Next</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
