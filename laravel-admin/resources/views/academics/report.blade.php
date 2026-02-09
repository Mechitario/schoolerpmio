@extends('layouts.app')

@section('title', 'Report Card — ' . $student->name . ' — ' . $examName)
@section('breadcrumb', 'Exam Report')

@section('content')
<style>
    @media print {
        body * { visibility: hidden; }
        .report-card-wrapper, .report-card-wrapper * { visibility: visible; }
        .report-card-wrapper { position: absolute; left: 0; top: 0; width: 100%; background: #fff; padding: 0; margin: 0; }
        .no-print { display: none !important; }
    }
</style>
<div class="max-w-2xl mx-auto print:max-w-none">
    <div class="no-print mb-6 flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Report Card</h1>
        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-medium rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print / Save as PDF
        </button>
    </div>

    <div class="report-card-wrapper bg-white text-gray-900 border border-gray-300 rounded-lg overflow-hidden shadow-sm print:shadow-none">
        {{-- Top: school name and exam --}}
        <div class="px-6 py-5 border-b border-gray-300 text-center">
            <p class="text-base font-semibold text-gray-900">EduManage School</p>
            <p class="text-sm text-gray-600 mt-0.5">Report Card — {{ $examName }}</p>
        </div>

        {{-- Student details: simple list --}}
        <div class="px-6 py-4 border-b border-gray-300 flex flex-wrap gap-x-8 gap-y-1 text-sm">
            <span><strong>Name:</strong> {{ $student->name }}</span>
            <span><strong>Roll No.:</strong> {{ $student->roll_number }}</span>
            <span><strong>Class:</strong> {{ $student->class_name }}{{ $student->section ? ' ' . $student->section : '' }}</span>
        </div>

        {{-- Marks table: plain bordered table --}}
        <div class="px-6 py-4">
            <table class="w-full border border-gray-300 border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 py-2 px-3 text-left font-semibold text-gray-800">Subject</th>
                        <th class="border border-gray-300 py-2 px-3 text-center font-semibold text-gray-800 w-20">Marks</th>
                        <th class="border border-gray-300 py-2 px-3 text-center font-semibold text-gray-800 w-16">Max</th>
                        <th class="border border-gray-300 py-2 px-3 text-center font-semibold text-gray-800 w-16">%</th>
                        <th class="border border-gray-300 py-2 px-3 text-center font-semibold text-gray-800 w-16">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @php $totalMarks = 0; $obtained = 0; @endphp
                    @foreach($results as $row)
                    @php
                        $pct = $row->total_marks > 0 ? round(($row->marks / $row->total_marks) * 100, 1) : 0;
                        $grade = $pct >= 90 ? 'A+' : ($pct >= 80 ? 'A' : ($pct >= 70 ? 'B+' : ($pct >= 60 ? 'B' : ($pct >= 50 ? 'C' : 'D'))));
                        $totalMarks += $row->total_marks;
                        $obtained += $row->marks;
                    @endphp
                    <tr>
                        <td class="border border-gray-300 py-2 px-3 text-gray-900">{{ $row->subject }}</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-900">{{ $row->marks }}</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-600">{{ $row->total_marks }}</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-900">{{ number_format($pct, 1) }}%</td>
                        <td class="border border-gray-300 py-2 px-3 text-center font-medium text-gray-900">{{ $grade }}</td>
                    </tr>
                    @endforeach
                </tbody>
                @if($results->isNotEmpty())
                <tfoot>
                    <tr class="bg-gray-100 font-semibold">
                        <td class="border border-gray-300 py-2 px-3 text-gray-900">Total</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-900">{{ $obtained }}</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-900">{{ $totalMarks }}</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-900">{{ $totalMarks > 0 ? number_format(($obtained / $totalMarks) * 100, 1) : 0 }}%</td>
                        <td class="border border-gray-300 py-2 px-3 text-center text-gray-900">
                            @php
                                $overallPct = $totalMarks > 0 ? ($obtained / $totalMarks) * 100 : 0;
                                $overallGrade = $overallPct >= 90 ? 'A+' : ($overallPct >= 80 ? 'A' : ($overallPct >= 70 ? 'B+' : ($overallPct >= 60 ? 'B' : ($overallPct >= 50 ? 'C' : 'D'))));
                            @endphp
                            {{ $overallGrade }}
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        {{-- Footer: date and signatures --}}
        <div class="px-6 py-5 border-t border-gray-300">
            <p class="text-xs text-gray-500 mb-4">Date: {{ now()->format('F j, Y') }}</p>
            <div class="flex gap-16">
                <div>
                    <div class="w-28 border-b border-gray-400 mb-1 h-6"></div>
                    <p class="text-xs text-gray-600">Class Teacher</p>
                </div>
                <div>
                    <div class="w-28 border-b border-gray-400 mb-1 h-6"></div>
                    <p class="text-xs text-gray-600">Principal</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
