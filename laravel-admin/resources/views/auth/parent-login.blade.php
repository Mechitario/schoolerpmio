<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Login – Shri Memorial Public School</title>
    <script>
        (function() {
            var theme = localStorage.getItem('theme') || 'light';
            var root = document.documentElement;
            if (theme === 'dark') { root.classList.add('dark'); } else { root.classList.remove('dark'); }
            window.toggleTheme = function() {
                root = document.documentElement;
                var isDark = !root.classList.contains('dark');
                if (isDark) { root.classList.add('dark'); localStorage.setItem('theme', 'dark'); }
                else { root.classList.remove('dark'); localStorage.setItem('theme', 'light'); }
                var label = document.getElementById('theme-label');
                if (label) { label.textContent = isDark ? 'Light mode' : 'Night mode'; }
            };
        })();
    </script>
    <link href="{{ asset('css/app.css') }}?v={{ file_exists(public_path('css/app.css')) ? filemtime(public_path('css/app.css')) : 1 }}" rel="stylesheet">
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-purple-100 via-pink-100 to-cyan-100 dark:from-slate-950 dark:via-purple-950 dark:to-slate-900 transition-colors">
    <button type="button" id="theme-toggle" aria-label="Toggle night mode" onclick="window.toggleTheme && window.toggleTheme(); return false;" class="fixed top-4 right-4 z-20 inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-800/90 text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors shadow text-sm font-medium">
        <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        <span id="theme-label">Night mode</span>
    </button>
    <div class="w-full max-w-sm relative z-10">
        <div class="bg-white dark:bg-slate-800/90 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-2xl shadow-purple-500/20 dark:shadow-black/50 p-6 transition-colors">
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-purple-500 via-pink-500 to-cyan-500 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-purple-500/30">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Parent Portal</h1>
                <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Shri Memorial Public School</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('parent.login') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-2.5 bg-gray-100 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2.5 bg-gray-100 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 dark:border-slate-600 bg-gray-100 dark:bg-slate-700 text-purple-500 focus:ring-purple-500/50">
                    <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-slate-400">Remember me</label>
                </div>
                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-purple-500 via-pink-500 to-cyan-500 text-white font-semibold rounded-lg hover:from-purple-600 hover:via-pink-600 hover:to-cyan-600 shadow-lg shadow-purple-500/20 transition-all focus:ring-2 focus:ring-purple-500/50 focus:ring-offset-2 focus:ring-offset-slate-800">
                    Sign in
                </button>
            </form>
        </div>
        <p class="text-center text-sm text-gray-500 dark:text-slate-500 mt-5">
            <a href="{{ route('home') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">← Back to site</a>
        </p>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var label = document.getElementById('theme-label');
            if (label) label.textContent = document.documentElement.classList.contains('dark') ? 'Light mode' : 'Night mode';
        });
    </script>
</body>
</html>
