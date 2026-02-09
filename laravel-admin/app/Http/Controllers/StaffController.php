<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(Request $request): View
    {
        $query = Staff::query();

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->where(function ($qry) use ($q) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(role) LIKE ?', [$q]);
            });
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $staff = $query->latest()->paginate(15);
        $staffStatsQuery = $request->filled('year') ? Staff::whereYear('created_at', $request->year) : Staff::query();
        $totalSalary = (clone $staffStatsQuery)->sum('salary');
        $teachingRoles = ['Teacher', 'Senior Teacher', 'PE Teacher'];
        $teachingCount = (clone $staffStatsQuery)->whereIn('role', $teachingRoles)->count();
        $adminCount = (clone $staffStatsQuery)->whereNotIn('role', $teachingRoles)->count();

        $salaryYear = $request->query('salary_year') ?? date('Y');
        $paymentYear = $request->query('payment_year');
        $paymentsQuery = Salary::with('staff')->latest('paid_date');
        if ($paymentYear !== null && $paymentYear !== '') {
            $paymentsQuery->where('month', 'like', '%' . $paymentYear);
        }
        if ($request->filled('search')) {
            $searchQ = '%' . mb_strtolower($request->search) . '%';
            $paymentsQuery->whereHas('staff', function ($q) use ($searchQ) {
                $q->whereRaw('LOWER(name) LIKE ?', [$searchQ])
                    ->orWhereRaw('LOWER(role) LIKE ?', [$searchQ]);
            });
        }
        $recentPayments = $paymentsQuery->take(50)->get();

        $monthNames = [];
        for ($m = 1; $m <= 12; $m++) {
            $d = Carbon::createFromDate((int) $salaryYear, $m, 1);
            $monthNames[] = $d->format('F Y');
        }
        $allStaffQuery = Staff::orderBy('name');
        if ($request->filled('search')) {
            $searchQ = '%' . mb_strtolower($request->search) . '%';
            $allStaffQuery->where(function ($qry) use ($searchQ) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$searchQ])
                    ->orWhereRaw('LOWER(role) LIKE ?', [$searchQ]);
            });
        }
        $allStaff = $allStaffQuery->get();
        $paidInYear = Salary::where('month', 'like', '%' . $salaryYear)->get()->groupBy('staff_id');
        $salaryStatus = [];
        foreach ($allStaff as $s) {
            $paidMonths = $paidInYear->get($s->id, collect())->pluck('month')->toArray();
            $dueMonths = array_values(array_diff($monthNames, $paidMonths));
            $salaryStatus[] = [
                'staff' => $s,
                'paid_months' => $paidMonths,
                'due_months' => $dueMonths,
                'payments' => $paidInYear->get($s->id, collect()),
            ];
        }

        $filterYears = range((int) date('Y') + 1, (int) date('Y') - 10);

        return view('staff.index', compact('staff', 'totalSalary', 'teachingCount', 'adminCount', 'recentPayments', 'salaryStatus', 'salaryYear', 'paymentYear', 'monthNames', 'filterYears'));
    }

    public function create(): View
    {
        return view('staff.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['salary'] = (float) $validated['salary'];

        Staff::create($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member added successfully.');
    }

    public function edit(Staff $staff): View
    {
        return view('staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'salary' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['salary'] = (float) $validated['salary'];
        $staff->update($validated);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully.');
    }

    public function salaries(Request $request): View
    {
        $staffList = Staff::orderBy('name')->get();
        $salaryQuery = Salary::with('staff')->latest('paid_date');
        if ($request->filled('year')) {
            $salaryQuery->whereYear('paid_date', $request->year);
        }
        $recentSalaries = $salaryQuery->take(20)->get();
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $d = Carbon::now()->subMonths($i);
            $months[$d->format('F Y')] = $d->format('F Y');
        }
        return view('staff.salaries', compact('staffList', 'recentSalaries', 'months'));
    }

    public function storeSalary(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'staff_id' => ['required', 'exists:staff,id'],
            'month' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        Salary::create([
            'staff_id' => $validated['staff_id'],
            'amount' => (float) $validated['amount'],
            'month' => $validated['month'],
            'paid_date' => now(),
        ]);

        return redirect()->route('admin.staff.salaries')
            ->with('success', 'Salary payment recorded successfully.');
    }
}
