<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent Dashboard – Shri Memorial Public School</title>
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
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .report-card { page-break-after: always; }
        }
        .report-card {
            background: white;
            border: 3px solid #1e293b;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-left: auto;
            margin-right: auto;
        }
        .dark .report-card {
            background: #1e293b;
            border-color: #475569;
        }
        .report-header {
            border-bottom: 3px solid #1e293b;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .dark .report-header {
            border-bottom-color: #475569;
        }
        .grade-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: bold;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 dark:bg-slate-900 transition-colors">
    <!-- Navigation Bar -->
    <nav class="no-print bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 via-pink-500 to-cyan-500 flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold text-gray-900 dark:text-white">Shri Memorial Public School</h1>
                        <p class="text-xs text-gray-500 dark:text-slate-400">Parent Portal - Academic Report Cards</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-purple-100 dark:bg-purple-900/30">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ substr($parent->name, 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-gray-700 dark:text-slate-300">{{ $parent->name }}</span>
                    </div>
                    <button type="button" onclick="window.toggleTheme && window.toggleTheme(); return false;" class="p-2 rounded-lg border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-600 transition-colors">
                        <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <svg class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('parent.logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 text-white font-medium rounded-lg shadow-md transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-6 sm:px-8 lg:px-12 py-8">
        <!-- Filters -->
        @if($parent->students->isNotEmpty())
        <div class="no-print mb-6 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-4 shadow-sm max-w-3xl mx-auto">
            <form method="GET" action="{{ route('parent.dashboard') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Select Child</label>
                    <select name="student_id" id="student_id" onchange="this.form.submit();" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all">
                        <option value="">All Children</option>
                        @foreach($parent->students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->class_name }}{{ $student->section ? ' ' . $student->section : '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label for="exam" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Select Exam</label>
                    <select name="exam" id="exam" onchange="this.form.submit();" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500 transition-all">
                        <option value="">All Exams</option>
                        @foreach($examTypes as $exam)
                            <option value="{{ $exam }}" {{ request('exam') == $exam ? 'selected' : '' }}>{{ $exam }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        @endif

        @if($parent->students->isEmpty())
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-12 text-center shadow-sm max-w-3xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <p class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-2">No Children Linked</p>
                <p class="text-gray-500 dark:text-slate-400">Please contact the school administration to link your children to your account.</p>
            </div>
        @elseif(empty($groupedResults))
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-slate-700 p-12 text-center shadow-sm max-w-3xl mx-auto">
                <div class="w-16 h-16 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-500 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-lg font-semibold text-gray-700 dark:text-slate-300 mb-2">No Results Found</p>
                <p class="text-gray-500 dark:text-slate-400">No results available for the selected filters.</p>
            </div>
        @else
            @foreach($groupedResults as $studentId => $data)
                @php
                    $student = $data['student'];
                    $exams = $data['exams'];
                @endphp
                
                @foreach($exams as $examName => $results)
                    <!-- Report Card -->
                    <div class="report-card mb-8 rounded-lg overflow-hidden max-w-3xl mx-auto">
                        <!-- Report Card Header -->
                        <div class="report-header px-6 py-5">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-14 h-14 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center border-2 border-white/30">
                                            <span class="text-xl font-bold text-white">{{ substr($student->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-bold text-white mb-1">{{ $student->name }}</h2>
                                            <p class="text-white/90 text-xs">Roll No: {{ $student->roll_number }} | Class: {{ $student->class_name }}{{ $student->section ? ' ' . $student->section : '' }}</p>
                                        </div>
                                    </div>
                                    <div class="border-t border-white/20 pt-3">
                                        <h3 class="text-lg font-semibold text-white mb-1">{{ $examName }} - Academic Report Card</h3>
                                        <p class="text-white/80 text-xs">Shri Memorial Public School</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-2 border border-white/30">
                                        <p class="text-white/80 text-xs mb-1">Academic Year</p>
                                        <p class="text-white font-semibold text-sm">{{ date('Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Report Card Body -->
                        <div class="px-6 py-5 bg-white dark:bg-slate-800">
                            <!-- Subject Results Table -->
                            <div class="mb-5">
                                <h4 class="text-base font-bold text-gray-900 dark:text-white mb-3 border-b-2 border-gray-300 dark:border-slate-600 pb-2">Subject-wise Performance</h4>
                                <table class="w-full border-collapse text-sm">
                                    <thead>
                                        <tr class="bg-gray-100 dark:bg-slate-700">
                                            <th class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-left font-bold text-gray-900 dark:text-white text-xs">Subject</th>
                                            <th class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-bold text-gray-900 dark:text-white text-xs">Marks</th>
                                            <th class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-bold text-gray-900 dark:text-white text-xs">Total</th>
                                            <th class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-bold text-gray-900 dark:text-white text-xs">%</th>
                                            <th class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-bold text-gray-900 dark:text-white text-xs">Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalMarks = 0;
                                            $obtainedMarks = 0;
                                        @endphp
                                        @foreach($results as $result)
                                            @php
                                                $percentage = $result->total_marks > 0 ? round(($result->marks / $result->total_marks) * 100, 1) : 0;
                                                $grade = $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B+' : ($percentage >= 60 ? 'B' : ($percentage >= 50 ? 'C' : 'D'))));
                                                $gradeColor = $percentage >= 90 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : ($percentage >= 80 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : ($percentage >= 70 ? 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300' : ($percentage >= 60 ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300')));
                                                $totalMarks += $result->total_marks;
                                                $obtainedMarks += $result->marks;
                                            @endphp
                                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                                <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 font-semibold text-gray-900 dark:text-white text-sm">{{ $result->subject }}</td>
                                                <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-bold text-gray-900 dark:text-white text-sm">{{ number_format($result->marks, 1) }}</td>
                                                <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center text-gray-700 dark:text-slate-300 text-sm">{{ number_format($result->total_marks, 1) }}</td>
                                                <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center font-semibold text-gray-900 dark:text-white text-sm">{{ number_format($percentage, 1) }}%</td>
                                                <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-2 text-center">
                                                    <span class="grade-badge {{ $gradeColor }} text-xs">{{ $grade }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $overallPercentage = $totalMarks > 0 ? round(($obtainedMarks / $totalMarks) * 100, 1) : 0;
                                            $overallGrade = $overallPercentage >= 90 ? 'A+' : ($overallPercentage >= 80 ? 'A' : ($overallPercentage >= 70 ? 'B+' : ($overallPercentage >= 60 ? 'B' : ($overallPercentage >= 50 ? 'C' : 'D'))));
                                            $overallGradeColor = $overallPercentage >= 90 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : ($overallPercentage >= 80 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : ($overallPercentage >= 70 ? 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-300' : ($overallPercentage >= 60 ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' : 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-300')));
                                        @endphp
                                        <tr class="bg-gray-100 dark:bg-slate-700 font-bold">
                                            <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-3 text-gray-900 dark:text-white text-sm">TOTAL</td>
                                            <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-3 text-center text-gray-900 dark:text-white text-sm">{{ number_format($obtainedMarks, 1) }}</td>
                                            <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-3 text-center text-gray-900 dark:text-white text-sm">{{ number_format($totalMarks, 1) }}</td>
                                            <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-3 text-center text-purple-600 dark:text-purple-400 text-base font-bold">{{ number_format($overallPercentage, 1) }}%</td>
                                            <td class="border-2 border-gray-300 dark:border-slate-600 px-3 py-3 text-center">
                                                <span class="grade-badge {{ $overallGradeColor }} text-sm">{{ $overallGrade }}</span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Summary Section -->
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-5">
                                <div class="bg-purple-50 dark:bg-purple-900/20 border-2 border-purple-200 dark:border-purple-800 rounded-lg p-3">
                                    <p class="text-xs text-purple-700 dark:text-purple-300 font-medium mb-1">Total Marks</p>
                                    <p class="text-xl font-bold text-purple-900 dark:text-purple-100">{{ number_format($obtainedMarks, 1) }} / {{ number_format($totalMarks, 1) }}</p>
                                </div>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-lg p-3">
                                    <p class="text-xs text-blue-700 dark:text-blue-300 font-medium mb-1">Overall Percentage</p>
                                    <p class="text-xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($overallPercentage, 1) }}%</p>
                                </div>
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-200 dark:border-emerald-800 rounded-lg p-3">
                                    <p class="text-xs text-emerald-700 dark:text-emerald-700 font-medium mb-1">Overall Grade</p>
                                    <p class="text-xl font-bold text-emerald-900 dark:text-emerald-100">{{ $overallGrade }}</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="border-t-2 border-gray-300 dark:border-slate-600 pt-3 mt-4">
                                <div class="flex justify-between items-center text-xs text-gray-600 dark:text-slate-400">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-white mb-1">Parent/Guardian Signature</p>
                                        <div class="mt-6 border-b-2 border-gray-400 dark:border-slate-500 w-40"></div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 dark:text-white mb-1">Class Teacher Signature</p>
                                        <div class="mt-6 border-b-2 border-gray-400 dark:border-slate-500 w-40 ml-auto"></div>
                                    </div>
                                </div>
                                <p class="text-center text-xs text-gray-500 dark:text-slate-500 mt-4">
                                    This is a computer-generated report card. For any queries, please contact the school administration.
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        @endif
    </main>
</body>
</html>
