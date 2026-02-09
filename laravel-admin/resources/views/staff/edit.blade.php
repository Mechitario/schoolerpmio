@extends('layouts.app')

@section('title', 'Edit Staff')
@section('breadcrumb', 'Edit Staff')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Staff Management
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Edit Staff Member</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.staff.update', $staff) }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Full name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $staff->name) }}" required autofocus
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. Jane Smith">
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Role <span class="text-rose-500">*</span></label>
                <select name="role" id="role" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">Select role</option>
                    <option value="Teacher" {{ old('role', $staff->role) === 'Teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="Senior Teacher" {{ old('role', $staff->role) === 'Senior Teacher' ? 'selected' : '' }}>Senior Teacher</option>
                    <option value="PE Teacher" {{ old('role', $staff->role) === 'PE Teacher' ? 'selected' : '' }}>PE Teacher</option>
                    <option value="Admin" {{ old('role', $staff->role) === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Accountant" {{ old('role', $staff->role) === 'Accountant' ? 'selected' : '' }}>Accountant</option>
                    <option value="Receptionist" {{ old('role', $staff->role) === 'Receptionist' ? 'selected' : '' }}>Receptionist</option>
                    <option value="Other" {{ old('role', $staff->role) === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div>
                <label for="salary" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Monthly salary <span class="text-rose-500">*</span></label>
                <input type="number" name="salary" id="salary" value="{{ old('salary', $staff->salary) }}" required min="0" step="0.01"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. 3500.00">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Update Staff
                </button>
                <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
