@extends('layouts.app')

@section('title', 'Admin Users')
@section('breadcrumb', 'Admin Users')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif
    <header class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-gray-900 dark:text-white">Admin Users</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-1">Manage user accounts and roles for portal access.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
            Add User
        </a>
    </header>

    <div class="bg-white dark:bg-slate-800/80 rounded-xl border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm dark:shadow-none">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Name</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Email</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Role</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-slate-100">{{ $user->name }}</td>
                        <td class="px-5 py-3 text-gray-700 dark:text-slate-300">{{ $user->email }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex text-xs font-medium px-2.5 py-1 rounded-lg bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-200 capitalize">{{ $user->role }}</span>
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center text-gray-500 dark:text-slate-500">
                            <p class="font-medium">No users found</p>
                            <p class="text-sm mt-1">Create a user account to grant portal access.</p>
                            <a href="{{ route('admin.users.create') }}" class="inline-block mt-3 text-cyan-600 dark:text-cyan-400 font-medium hover:underline">Add User</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
