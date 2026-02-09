@extends('layouts.app')

@section('title', 'Pay Salaries')
@section('breadcrumb', 'Pay Salaries')

@section('content')
<div class="space-y-6 max-w-4xl">
    <div class="mb-6">
        <a href="{{ route('admin.staff.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-slate-400 hover:text-cyan-600 dark:hover:text-cyan-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Staff Management
        </a>
    </div>

    @if (session('success'))
        <div class="p-3 rounded-lg bg-emerald-500/20 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm dark:shadow-none p-6">
        <h2 class="text-gray-900 dark:text-white mb-4">Record Salary Payment</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-500/20 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.staff.salaries.store') }}" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="staff_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Staff member <span class="text-rose-500">*</span></label>
                    <select name="staff_id" id="staff_id" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        <option value="">Select staff</option>
                        @foreach($staffList as $s)
                            <option value="{{ $s->id }}" data-salary="{{ $s->salary }}" {{ old('staff_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }} ({{ $s->role }}) — ${{ number_format($s->salary, 2) }}/mo
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="month" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Month <span class="text-rose-500">*</span></label>
                    <select name="month" id="month" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors">
                        @foreach($months as $value => $label)
                            <option value="{{ $value }}" {{ old('month') === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Amount ($) <span class="text-rose-500">*</span></label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required min="0" step="0.01"
                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-700/50 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-900 dark:text-slate-100 placeholder-gray-500 dark:placeholder-slate-500 focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-500 transition-colors"
                           placeholder="0.00">
                </div>
            </div>
            <div>
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-cyan-500 to-violet-600 text-white font-medium rounded-lg hover:from-cyan-400 hover:to-violet-500 shadow-lg shadow-cyan-500/20 transition-all">
                    Record Payment
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-slate-800/80 border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden shadow-sm dark:shadow-none">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
            <h2 class="text-gray-900 dark:text-white">Recent Salary Payments</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50">
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Staff</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Month</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider text-right">Amount</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-600 dark:text-slate-400 uppercase tracking-wider">Date paid</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($recentSalaries as $sal)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-5 py-3 font-medium text-gray-900 dark:text-slate-100">{{ $sal->staff->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-sm text-gray-600 dark:text-slate-300">{{ $sal->month }}</td>
                        <td class="px-5 py-3 text-right font-medium text-gray-900 dark:text-white">${{ number_format($sal->amount, 2) }}</td>
                        <td class="px-5 py-3 text-sm text-gray-500 dark:text-slate-400">{{ $sal->paid_date ? $sal->paid_date->format('M d, Y') : '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-500 dark:text-slate-500">No salary payments recorded yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.getElementById('staff_id').addEventListener('change', function() {
    var opt = this.options[this.selectedIndex];
    var amount = document.getElementById('amount');
    if (opt && opt.dataset.salary) {
        amount.value = parseFloat(opt.dataset.salary).toFixed(2);
    }
});
// Fill amount on load if staff is selected
var staffSelect = document.getElementById('staff_id');
if (staffSelect.value) {
    var opt = staffSelect.options[staffSelect.selectedIndex];
    if (opt && opt.dataset.salary && !document.getElementById('amount').value) {
        document.getElementById('amount').value = parseFloat(opt.dataset.salary).toFixed(2);
    }
}
</script>
@endsection
