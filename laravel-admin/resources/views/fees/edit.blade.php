@extends('layouts.app')

@section('title', 'Edit Fee Record')
@section('breadcrumb', 'Edit Fee Record')

@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <a href="{{ route('admin.fees.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Fee Tracking
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Edit Fee Record</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.fees.update', $fee) }}" class="space-y-4" id="fee-form">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Select Parent</label>
                    <select name="parent_id" id="parent_id"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        <option value="">None</option>
                        @foreach($parents as $p)
                            <option value="{{ $p->id }}" {{ old('parent_id', $fee->parent_id) == $p->id ? 'selected' : '' }}>
                                {{ $p->name }}{{ $p->phone ? ' — ' . $p->phone : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Student <span class="text-rose-500">*</span></label>
                    <select name="student_id" id="student_id" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        <option value="">Select student</option>
                        @foreach($students as $s)
                            @php
                                $sectionText = $s->section ? ' ' . $s->section : '';
                                $displayText = $s->name . ' — #' . $s->roll_number . ' (' . $s->class_name . $sectionText . ')';
                            @endphp
                            <option value="{{ $s->id }}" data-parent-id="{{ $s->parent_id }}" {{ old('student_id', $fee->student_id) == $s->id ? 'selected' : '' }}>
                                {{ $displayText }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Month <span class="text-rose-500">*</span></label>
                    <select name="month" id="month" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        @foreach($months as $value => $label)
                            <option value="{{ $value }}" {{ old('month', $fee->month) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Date</label>
                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', $fee->payment_date ? $fee->payment_date->format('Y-m-d') : date('Y-m-d')) }}"
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-slate-700 pt-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-300 mb-3">Fee Items</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="copy_fee" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Copy</label>
                        <input type="number" name="copy_fee" id="copy_fee" value="{{ old('copy_fee', $fee->copy_fee ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors fee-item"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="dress_fee" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Dress</label>
                        <input type="number" name="dress_fee" id="dress_fee" value="{{ old('dress_fee', $fee->dress_fee ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors fee-item"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="book_fee" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Book</label>
                        <input type="number" name="book_fee" id="book_fee" value="{{ old('book_fee', $fee->book_fee ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors fee-item"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="exam_fee" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Exam Fee</label>
                        <input type="number" name="exam_fee" id="exam_fee" value="{{ old('exam_fee', $fee->exam_fee ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors fee-item"
                               placeholder="0.00">
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 dark:border-slate-700 pt-4">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-slate-300 mb-3">Payment Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="total_amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Total</label>
                        <input type="text" id="total_amount" readonly value="{{ number_format(($fee->copy_fee ?? 0) + ($fee->dress_fee ?? 0) + ($fee->book_fee ?? 0) + ($fee->exam_fee ?? 0), 2) }}"
                               class="w-full px-4 py-2.5 bg-gray-100 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 font-semibold">
                        <input type="hidden" name="amount" id="amount" value="{{ ($fee->copy_fee ?? 0) + ($fee->dress_fee ?? 0) + ($fee->book_fee ?? 0) + ($fee->exam_fee ?? 0) }}">
                    </div>
                    <div>
                        <label for="received_amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Received</label>
                        <input type="number" name="received_amount" id="received_amount" value="{{ old('received_amount', $fee->received_amount ?? $fee->paid_amount ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="balance_carried_forward" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">New B/C (Balance Carried Forward)</label>
                        <input type="number" name="balance_carried_forward" id="balance_carried_forward" value="{{ old('balance_carried_forward', $fee->balance_carried_forward ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                               placeholder="0.00">
                    </div>
                    <div>
                        <label for="waived_off" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Waived Off</label>
                        <input type="number" name="waived_off" id="waived_off" value="{{ old('waived_off', $fee->waived_off ?? 0) }}" min="0" step="0.01"
                               class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                               placeholder="0.00">
                    </div>
                </div>
            </div>

            <div>
                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Remarks</label>
                <textarea name="remarks" id="remarks" rows="3"
                          class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                          placeholder="Optional notes...">{{ old('remarks', $fee->remarks) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Update Record
                </button>
                <a href="{{ route('admin.fees.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-slate-800 text-gray-700 dark:text-slate-200 font-medium rounded-lg border border-gray-300 dark:border-slate-600 hover:border-cyan-500/50 transition-all shadow-sm dark:shadow-none">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    var parentSelect = document.getElementById('parent_id');
    var studentSelect = document.getElementById('student_id');
    var allStudents = Array.from(studentSelect.options).slice(1);
    
    function filterStudents() {
        var parentId = parentSelect.value;
        var currentStudentId = studentSelect.value;
        studentSelect.innerHTML = '<option value="">Select student</option>';
        allStudents.forEach(function(opt) {
            var optParentId = opt.getAttribute('data-parent-id');
            if (!parentId || optParentId === parentId || optParentId === '') {
                var cloned = opt.cloneNode(true);
                studentSelect.appendChild(cloned);
            }
        });
        if (currentStudentId) {
            studentSelect.value = currentStudentId;
        }
    }
    
    parentSelect.addEventListener('change', filterStudents);
    
    var feeItems = document.querySelectorAll('.fee-item');
    var totalInput = document.getElementById('total_amount');
    var amountHidden = document.getElementById('amount');
    
    function calculateTotal() {
        var total = 0;
        feeItems.forEach(function(input) {
            total += parseFloat(input.value || 0);
        });
        totalInput.value = total.toFixed(2);
        amountHidden.value = total.toFixed(2);
    }
    
    feeItems.forEach(function(input) {
        input.addEventListener('input', calculateTotal);
    });
    calculateTotal();
})();
</script>
@endsection
