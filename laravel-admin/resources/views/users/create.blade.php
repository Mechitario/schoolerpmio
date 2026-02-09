@extends('layouts.app')

@section('title', 'Add User')
@section('breadcrumb', 'Add User')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Admin Users
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Create User Account</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Full name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. John Doe">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Email (Username) <span class="text-rose-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. john@school.com">
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-500">They will log in with this email.</p>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password" id="password" required minlength="8"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="Min 8 characters">
            </div>
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Confirm Password <span class="text-rose-500">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Role <span class="text-rose-500">*</span></label>
                <select name="role" id="role" required
                        class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    <option value="">Select role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role }}" {{ old('role') === $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="pt-4 border-t border-gray-200 dark:border-slate-700">
                <p class="text-sm font-medium text-gray-700 dark:text-slate-300 mb-3">Access permissions</p>
                <p class="text-xs text-gray-500 dark:text-slate-500 mb-3">Choose which sections this user can view in the admin dashboard.</p>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="can_view_dashboard" value="1" {{ old('can_view_dashboard', 1) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-cyan-600 focus:ring-cyan-500/50">
                        <span class="text-gray-700 dark:text-slate-300">Dashboard overview</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="can_view_admin_users" value="1" {{ old('can_view_admin_users', 0) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-cyan-600 focus:ring-cyan-500/50">
                        <span class="text-gray-700 dark:text-slate-300">Admin users management</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="can_view_students" value="1" {{ old('can_view_students', 1) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-cyan-600 focus:ring-cyan-500/50">
                        <span class="text-gray-700 dark:text-slate-300">Students section</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="can_view_staff" value="1" {{ old('can_view_staff', 1) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-cyan-600 focus:ring-cyan-500/50">
                        <span class="text-gray-700 dark:text-slate-300">Staff & Teachers section</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="can_view_fees" value="1" {{ old('can_view_fees', 1) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-cyan-600 focus:ring-cyan-500/50">
                        <span class="text-gray-700 dark:text-slate-300">Fee Tracking section</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="can_view_academics" value="1" {{ old('can_view_academics', 1) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-cyan-600 focus:ring-cyan-500/50">
                        <span class="text-gray-700 dark:text-slate-300">Exam Results section</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
