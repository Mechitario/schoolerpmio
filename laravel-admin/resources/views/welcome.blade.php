@extends('layouts.app')

@section('title', 'Shri Memorial Public School')
@section('breadcrumb', 'School Website')

@section('content')
<div class="min-h-full">
    <section class="relative min-h-[55vh] flex items-center justify-center overflow-hidden rounded-2xl border border-gray-200 dark:border-slate-700 mb-8 bg-white dark:bg-slate-950 shadow-sm dark:shadow-none">
        <div class="absolute inset-0 bg-gradient-to-br from-cyan-100/80 dark:from-cyan-900/30 via-transparent dark:via-transparent to-violet-100/80 dark:to-violet-900/30"></div>
        <div class="absolute inset-0 bg-gray-900/0 dark:bg-slate-900/50"></div>
        <div class="relative z-10 text-center px-6 py-20 max-w-3xl mx-auto">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white tracking-tight drop-shadow-lg bg-gradient-to-r from-cyan-600 via-gray-800 to-violet-600 dark:from-cyan-200 dark:via-white dark:to-violet-200 bg-clip-text text-transparent">
                Welcome to Shri Memorial Public School
            </h1>
            <p class="text-xl text-gray-600 dark:text-slate-300 mt-6 drop-shadow max-w-2xl mx-auto">
                We don't build hope, We build Future.
            </p>
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-semibold shadow-lg shadow-cyan-500/25 hover:from-cyan-400 hover:to-violet-500 transition-all">
                    Admin Portal
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('parent.login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold shadow-lg shadow-emerald-500/25 hover:from-emerald-400 hover:to-teal-500 transition-all">
                    Parent Portal
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="#about" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-800/50 text-gray-700 dark:text-slate-200 font-medium hover:bg-gray-50 dark:hover:bg-slate-700 hover:border-cyan-500/50 transition-all">
                    Learn more
                </a>
            </div>
        </div>
    </section>

    <section id="about" class="mb-16 scroll-mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-900 h-80 flex items-center justify-center">
                <img src="{{ asset('images/shri-memorial-logo.png') }}" alt="Shri Memorial Public School logo" class="max-h-full w-auto object-contain">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">About Our School</h2>
                <p class="text-gray-600 dark:text-slate-300 leading-relaxed mb-4">
                    Shri Memorial Public School is a place where every child is encouraged to learn, grow, and achieve.
                    We offer a balanced curriculum from primary through senior secondary, with modern facilities
                    and dedicated teachers.
                </p>
                <p class="text-gray-600 dark:text-slate-300 leading-relaxed mb-6">
                    Our campus includes well-equipped classrooms, a library, science and computer labs,
                    and sports facilities. We believe in holistic development and offer a range of
                    extracurricular activities.
                </p>
                <div class="flex flex-wrap gap-6 text-sm">
                    <span class="flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-medium">1,200+ Students</span>
                    <span class="flex items-center gap-2 text-violet-600 dark:text-violet-400 font-medium">80+ Staff</span>
                    <span class="flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-medium">Est. 1995</span>
                </div>
            </div>
        </div>
    </section>

    <section class="relative rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800/80 p-8 md:p-12 text-center shadow-sm dark:shadow-none">
        <div class="absolute inset-0 bg-gradient-to-r from-cyan-50 dark:from-cyan-900/20 via-white dark:via-slate-800 to-violet-50 dark:to-violet-900/20"></div>
        <div class="relative z-10">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Ready to get started?</h2>
            <p class="text-gray-500 dark:text-slate-400 text-sm mb-6 max-w-xl mx-auto">
                Admin and staff can log in to the admin portal. Parents can log in to view their children's results and academic progress.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-semibold shadow-lg shadow-cyan-500/20 hover:from-cyan-400 hover:to-violet-500 transition-all">
                    Admin Portal
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('parent.login') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold shadow-lg shadow-emerald-500/20 hover:from-emerald-400 hover:to-teal-500 transition-all">
                    Parent Portal
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
