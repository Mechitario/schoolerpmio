@extends('layouts.app')

@section('title', 'Edit Student')
@section('breadcrumb', 'Edit Student')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Student Directory
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Edit Student</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Full name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required autofocus
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. John Doe">
            </div>
            <div>
                <label for="roll_number" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Roll number <span class="text-rose-500">*</span></label>
                <input type="text" name="roll_number" id="roll_number" value="{{ old('roll_number', $student->roll_number) }}" required
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. 2024001">
            </div>
            <div>
                <label for="class_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Class <span class="text-rose-500">*</span></label>
                <select name="class_name" id="class_name" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">Select class</option>
                    @foreach(range(1, 12) as $n)
                        <option value="{{ $n }}" {{ old('class_name', $student->class_name) === (string)$n ? 'selected' : '' }}>Class {{ $n }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Batch year <span class="text-rose-500">*</span></label>
                <select name="year" id="year" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    @foreach(range((int) date('Y'), (int) date('Y') - 15) as $y)
                        <option value="{{ $y }}" {{ old('year', $student->year ?? date('Y')) === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="section" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Section (optional)</label>
                <input type="text" name="section" id="section" value="{{ old('section', $student->section) }}"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. A">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Update Student
                </button>
                <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
