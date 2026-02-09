@extends('layouts.app')

@section('title', 'Record Marks')
@section('breadcrumb', 'Record Marks')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.academics.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Exam Results
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-2">Record marks (subject-wise) for a student</h2>
        <p class="text-sm text-gray-500 dark:text-slate-400 mb-6">Select a student and exam, then enter marks for each subject.</p>

        @if (session('error'))
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.academics.store') }}" id="marks-form" class="space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Student <span class="text-rose-500">*</span></label>
                    <select name="student_id" id="student_id" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        <option value="">Select student</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}" {{ old('student_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }} — {{ $s->roll_number }} (Class {{ $s->class_name }}{{ $s->section ? '-' . $s->section : '' }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="exam_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Exam <span class="text-rose-500">*</span></label>
                    <input type="text" name="exam_name" id="exam_name" value="{{ old('exam_name') }}" list="exam_list" required
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                           placeholder="e.g. Mid-Term 2025">
                    <datalist id="exam_list">
                        @foreach($examNames as $e)
                            <option value="{{ $e }}">
                        @endforeach
                    </datalist>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-slate-300">Subjects & marks <span class="text-rose-500">*</span></label>
                    <button type="button" id="add-subject" class="text-sm font-medium text-cyan-600 dark:text-cyan-400 hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors">+ Add subject</button>
                </div>
                <div id="subjects-container" class="space-y-3">
                    @php $oldSubjects = old('subjects', [['subject' => '', 'marks' => '', 'total_marks' => '100']]); @endphp
                    @foreach($oldSubjects as $idx => $sub)
                    <div class="subject-row flex flex-wrap items-end gap-3 p-3 rounded-lg bg-gray-50 dark:bg-slate-700/30 border border-gray-200 dark:border-slate-600">
                        <div class="flex-1 min-w-[140px]">
                            <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1">Subject</label>
                            <select name="subjects[{{ $idx }}][subject]" class="subject-select w-full px-3 py-2 bg-white dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                                <option value="">Select</option>
                                @foreach($subjects as $subj)
                                    <option value="{{ $subj }}" {{ (isset($sub['subject']) && $sub['subject'] === $subj) ? 'selected' : '' }}>{{ $subj }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-24">
                            <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1">Marks</label>
                            <input type="number" name="subjects[{{ $idx }}][marks]" value="{{ $sub['marks'] ?? '' }}" min="0" step="0.01" placeholder="0"
                                   class="w-full px-3 py-2 bg-white dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        </div>
                        <div class="w-24">
                            <label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1">Out of</label>
                            <input type="number" name="subjects[{{ $idx }}][total_marks]" value="{{ $sub['total_marks'] ?? '100' }}" min="0.01" step="0.01" placeholder="100"
                                   class="w-full px-3 py-2 bg-white dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        </div>
                        <button type="button" class="remove-subject px-3 py-2 text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 rounded-lg text-sm font-medium transition-colors">Remove</button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Save marks
                </button>
                <a href="{{ route('admin.academics.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    var container = document.getElementById('subjects-container');
    var addBtn = document.getElementById('add-subject');
    var subjectOptions = @json($subjects);

    function nextIndex() {
        var rows = container.querySelectorAll('.subject-row');
        return rows.length;
    }

    function addRow() {
        var idx = nextIndex();
        var row = document.createElement('div');
        row.className = 'subject-row flex flex-wrap items-end gap-3 p-3 rounded-lg bg-gray-50 dark:bg-slate-700/30 border border-gray-200 dark:border-slate-600';
        var opts = subjectOptions.map(function(s) { return '<option value="' + s + '">' + s + '</option>'; }).join('');
        row.innerHTML = '<div class="flex-1 min-w-[140px]"><label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1">Subject</label><select name="subjects[' + idx + '][subject]" class="subject-select w-full px-3 py-2 bg-white dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"><option value="">Select</option>' + opts + '</select></div><div class="w-24"><label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1">Marks</label><input type="number" name="subjects[' + idx + '][marks]" min="0" step="0.01" placeholder="0" class="w-full px-3 py-2 bg-white dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"></div><div class="w-24"><label class="block text-xs font-medium text-gray-500 dark:text-slate-400 mb-1">Out of</label><input type="number" name="subjects[' + idx + '][total_marks]" value="100" min="0.01" step="0.01" placeholder="100" class="w-full px-3 py-2 bg-white dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 text-sm focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"></div><button type="button" class="remove-subject px-3 py-2 text-rose-600 dark:text-rose-400 hover:bg-rose-500/10 rounded-lg text-sm font-medium transition-colors">Remove</button>';
        container.appendChild(row);
        row.querySelector('.remove-subject').addEventListener('click', function() { removeRow(row); });
    }

    function removeRow(row) {
        var rows = container.querySelectorAll('.subject-row');
        if (rows.length <= 1) return;
        row.remove();
    }

    addBtn.addEventListener('click', addRow);
    container.querySelectorAll('.remove-subject').forEach(function(btn) {
        btn.addEventListener('click', function() { removeRow(btn.closest('.subject-row')); });
    });
})();
</script>
@endsection
