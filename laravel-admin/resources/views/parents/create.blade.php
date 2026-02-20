@extends('layouts.app')

@section('title', 'Add Parent')
@section('breadcrumb', 'Add Parent')

@section('content')
<div class="max-w-xl">
    <div class="mb-6">
        <a href="{{ route('admin.parents.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Parents
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Add Parent / Guardian</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.parents.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Full name <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. Rajesh Kumar">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Email (Username for Parent Portal)</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. rajesh@example.com">
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-500">Email is used as username for parent portal login</p>
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Password (Parent Portal)</label>
                <input type="password" name="password" id="password" value="{{ old('password') }}"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="Leave blank to use default: password">
                <p class="mt-1 text-xs text-gray-500 dark:text-slate-500">Minimum 6 characters. If left blank, default password "password" will be set.</p>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Phone</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                       class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                       placeholder="e.g. 9876543210">
            </div>
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Address</label>
                <textarea name="address" id="address" rows="2"
                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                          placeholder="Optional">{{ old('address') }}</textarea>
            </div>
            <div id="student-link-wrapper">
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">Link to students (children)</label>
                <p class="text-xs text-gray-500 dark:text-slate-500 mb-2">Search and select one or more students to link to this parent.</p>
                <div id="student-link-selected" class="flex flex-wrap gap-2 min-h-[2.5rem] p-2 rounded-t-lg border border-b-0 border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-700/30"></div>
                <input type="text" id="student-link-search" autocomplete="off" placeholder="Search by name, class, or roll number..."
                       class="w-full px-4 py-2.5 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-none text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                <div id="student-link-dropdown" class="max-h-52 overflow-y-auto border border-t-0 border-gray-300 dark:border-slate-600 rounded-b-lg bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700"></div>
                <div id="student-link-hidden-inputs"></div>
                @if($students->isEmpty())
                <p class="text-sm text-gray-500 dark:text-slate-500 mt-2">No students in the system yet. Add students first, then link them here or from the student edit page.</p>
                @endif
            </div>
            <script>
            (function() {
                var data = {
                    students: @json($studentsForLink),
                    selectedIds: @json(old('student_ids', []))
                };
                var selectedEl = document.getElementById('student-link-selected');
                var searchEl = document.getElementById('student-link-search');
                var dropdownEl = document.getElementById('student-link-dropdown');
                var hiddenContainer = document.getElementById('student-link-hidden-inputs');
                function renderHidden() {
                    hiddenContainer.innerHTML = '';
                    data.selectedIds.forEach(function(id) {
                        var inp = document.createElement('input');
                        inp.type = 'hidden';
                        inp.name = 'student_ids[]';
                        inp.value = id;
                        hiddenContainer.appendChild(inp);
                    });
                }
                function renderSelected() {
                    selectedEl.innerHTML = '';
                    data.selectedIds.forEach(function(id) {
                        var s = data.students.find(function(x) { return x.id == id; });
                        if (!s) return;
                        var chip = document.createElement('span');
                        chip.className = 'inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm bg-cyan-500/20 dark:bg-cyan-500/30 text-cyan-800 dark:text-cyan-200 border border-cyan-500/40';
                        chip.setAttribute('data-student-id', String(id));
                        var textSpan = document.createElement('span');
                        textSpan.textContent = s.name + ' (' + s.class_name + (s.section ? ' ' + s.section : '') + ')';
                        chip.appendChild(textSpan);
                        var btn = document.createElement('button');
                        btn.type = 'button';
                        btn.setAttribute('aria-label', 'Remove');
                        btn.setAttribute('title', 'Remove');
                        btn.setAttribute('data-remove-student', '1');
                        btn.className = 'ml-0.5 p-1 rounded-full text-cyan-700 dark:text-cyan-200 hover:bg-rose-500/30 hover:text-rose-700 dark:hover:text-rose-300 cursor-pointer inline-flex items-center justify-center shrink-0 border border-transparent hover:border-rose-400/50 transition-colors';
                        btn.innerHTML = '<svg class="w-4 h-4 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>';
                        chip.appendChild(btn);
                        selectedEl.appendChild(chip);
                    });
                    renderHidden();
                }
                function filterList() {
                    var q = (searchEl.value || '').toLowerCase().trim();
                    var available = data.students.filter(function(s) {
                        if (data.selectedIds.indexOf(s.id) !== -1) return false;
                        if (!q) return true;
                        var text = (s.name + ' ' + s.class_name + (s.section || '') + ' ' + s.roll_number).toLowerCase();
                        return text.indexOf(q) !== -1;
                    });
                    dropdownEl.innerHTML = '';
                    if (available.length === 0) {
                        dropdownEl.innerHTML = '<p class="px-4 py-3 text-sm text-gray-500 dark:text-slate-500">No matching students' + (q ? '.' : ' to add.') + '</p>';
                        return;
                    }
                    available.forEach(function(s) {
                        var row = document.createElement('button');
                        row.type = 'button';
                        row.className = 'w-full text-left px-4 py-2.5 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors flex justify-between items-center';
                        row.innerHTML = '<span>' + (s.name) + '</span><span class="text-xs text-gray-500 dark:text-slate-500">' + s.class_name + (s.section ? ' ' + s.section : '') + ', #' + s.roll_number + '</span>';
                        row.onclick = function() {
                            data.selectedIds.push(s.id);
                            searchEl.value = '';
                            render();
                            searchEl.focus();
                        };
                        dropdownEl.appendChild(row);
                    });
                }
                function render() {
                    renderSelected();
                    filterList();
                }
                selectedEl.addEventListener('click', function(e) {
                    var removeBtn = e.target.closest('button[data-remove-student]');
                    if (removeBtn) {
                        e.preventDefault();
                        e.stopPropagation();
                        var chip = removeBtn.closest('[data-student-id]');
                        if (chip) {
                            var id = chip.getAttribute('data-student-id');
                            data.selectedIds = data.selectedIds.filter(function(x) { return String(x) !== String(id); });
                            render();
                        }
                    }
                });
                searchEl.addEventListener('input', filterList);
                searchEl.addEventListener('focus', function() { dropdownEl.style.display = 'block'; });
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('#student-link-wrapper')) dropdownEl.style.display = 'none';
                });
                render();
            })();
            </script>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Add Parent
                </button>
                <a href="{{ route('admin.parents.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
