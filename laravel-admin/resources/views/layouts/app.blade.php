<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shri Memorial Public School Admin')</title>
    {{-- Set theme before CSS loads; define toggle so it works on first click --}}
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
<body class="font-sans bg-gray-100 text-gray-900 dark:bg-slate-900 dark:text-slate-100 antialiased min-h-screen transition-colors">
    <div class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex w-64 flex-col bg-white dark:bg-slate-950 border-r border-gray-200 dark:border-slate-800 z-20 transition-colors">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-4 border-b border-gray-200 dark:border-slate-800 transition-colors">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan-500 to-violet-600 flex items-center justify-center text-white flex-shrink-0 shadow-lg shadow-cyan-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span class="font-bold text-white text-sm bg-gradient-to-r from-cyan-400 to-violet-400 bg-clip-text text-transparent">Shri Memorial Public School</span>
            </a>

            <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0">
                <div class="px-3 py-2 text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase tracking-wider">Site</div>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('home') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    School Website
                </a>
                <div class="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase tracking-wider">Portal</div>
                @if(auth()->check() && auth()->user()->can_view_dashboard)
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                @endif
                <div class="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase tracking-wider">Management</div>
                @if(auth()->check() && auth()->user()->can_view_students)
                <a href="{{ route('admin.students.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.students.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Students
                </a>
                @endif
                @if(auth()->check() && auth()->user()->can_view_parents)
                <a href="{{ route('admin.parents.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.parents.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Parents
                </a>
                @endif
                @if(auth()->check() && auth()->user()->can_view_staff)
                <a href="{{ route('admin.staff.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.staff.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Staff & Teachers
                </a>
                @endif
                @if(auth()->check() && auth()->user()->can_view_fees)
                <a href="{{ route('admin.fees.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.fees.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Fee Tracking
                </a>
                @endif
                @if(auth()->check() && auth()->user()->can_view_inventory)
                <a href="{{ route('admin.inventory.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.inventory.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8 4-8-4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    Inventory
                </a>
                @endif
                <div class="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase tracking-wider">Academic</div>
                @if(auth()->check() && auth()->user()->can_view_academics)
                <a href="{{ route('admin.academics.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.academics.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    Exam Results
                </a>
                @endif
                <div class="px-3 py-2 pt-4 text-xs font-semibold text-gray-500 dark:text-slate-500 uppercase tracking-wider">System</div>
                @if(auth()->check() && auth()->user()->can_view_admin_users)
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-cyan-500/20 to-violet-500/20 text-cyan-600 dark:text-cyan-300 border border-cyan-500/30' : 'text-gray-600 dark:text-slate-400 hover:text-gray-900 dark:hover:text-slate-200 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Admin Users
                </a>
                @endif
            </nav>

            <div class="mt-auto p-4 border-t border-gray-200 dark:border-slate-800 transition-colors">
                @auth
                <div class="flex items-center gap-3 px-3 py-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=06b6d4&color=fff&size=80" alt="" class="w-8 h-8 rounded-full flex-shrink-0 ring-2 ring-cyan-500/50">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-slate-200 truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-slate-500 truncate capitalize">{{ auth()->user()->role ?? 'Admin' }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-gray-500 dark:text-slate-400 hover:text-rose-500 dark:hover:text-rose-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-cyan-700 dark:hover:text-cyan-300 transition-all">Login</a>
                @endauth
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <header class="h-14 bg-white dark:bg-slate-800/80 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between px-4 lg:px-6 flex-shrink-0 backdrop-blur transition-colors">
                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium text-gray-600 dark:text-slate-300">@yield('breadcrumb', 'Dashboard')</span>
                    @unless(request()->routeIs('admin.fees.*') || request()->routeIs('admin.dashboard*') || request()->routeIs('admin.students.*') || request()->routeIs('admin.staff.*'))
                    <form method="get" action="{{ url()->current() }}" class="flex items-center gap-2" id="year-filter-form">
                        @foreach(request()->except('year', 'page') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <label for="year-filter" class="text-xs font-medium text-gray-500 dark:text-slate-400 whitespace-nowrap">Year:</label>
                        <select name="year" id="year-filter" onchange="document.getElementById('year-filter-form').submit();" class="text-sm bg-gray-100 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg px-2.5 py-1.5 text-gray-900 dark:text-slate-200 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                            <option value="">All years</option>
                            @foreach($filterYears ?? [] as $y)
                                <option value="{{ $y }}" {{ (string)($filterYear ?? '') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </form>
                    @endunless
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" id="theme-toggle" aria-label="Toggle night mode" onclick="window.toggleTheme && window.toggleTheme(); return false;" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-200 dark:border-slate-600 bg-gray-100 dark:bg-slate-700/50 text-gray-700 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors text-sm font-medium">
                        <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <span id="theme-label">Night mode</span>
                    </button>
                    <div class="hidden md:block relative">
                        <input type="text" placeholder="Search..." class="w-64 pl-9 pr-3 py-2 text-sm bg-gray-100 dark:bg-slate-700/50 border border-gray-200 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-200 placeholder-gray-500 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                    </div>
                    @auth
                    <span class="text-sm text-gray-600 dark:text-slate-300">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 dark:text-slate-400 hover:text-rose-500 dark:hover:text-rose-400 transition-colors">Logout</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 font-medium transition-colors">Login</a>
                    @endauth
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-100 dark:bg-slate-900 p-4 lg:p-6 transition-colors">
                @yield('content')
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var label = document.getElementById('theme-label');
            if (label) label.textContent = document.documentElement.classList.contains('dark') ? 'Light mode' : 'Night mode';
        });
    </script>
</body>
</html>
