<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Staff;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Response as ResponseFacade;

class DashboardController extends Controller
{
    private function getDashboardData(int $recentLimit = 5, array $reportFilters = [], array $listFilters = []): array
    {
        $studentCount = Student::count();
        $staffCount = Staff::count();

        $reportType = $reportFilters['report_type'] ?? null;
        $reportYear = $reportFilters['report_year'] ?? null;
        $reportMonth = $reportFilters['report_month'] ?? null;

        $feeQuery = Fee::query();
        if ($reportType === 'monthly' && $reportMonth !== null && $reportMonth !== '') {
            $feeQuery->where('month', $reportMonth);
        } elseif (($reportType === 'yearly' || $reportType === null) && $reportYear !== null && $reportYear !== '') {
            $feeQuery->where('month', 'like', '%' . $reportYear);
        }

        if ($reportType === 'monthly' && $reportMonth) {
            $monthlyRevenue = (clone $feeQuery)->sum('paid_amount');
        } elseif ($reportYear) {
            $monthlyRevenue = (clone $feeQuery)->sum('paid_amount');
        } else {
            $monthlyRevenue = Fee::whereMonth('paid_date', now()->month)
                ->whereYear('paid_date', now()->year)
                ->sum('paid_amount');
        }

        $pendingFees = (float) (clone $feeQuery)->selectRaw('COALESCE(SUM(amount - paid_amount), 0) as total')->value('total');

        // Recent Fee Collections list with optional filters
        $listQuery = Fee::query()->with(['student', 'parent']);
        if ($reportType === 'monthly' && $reportMonth) {
            $listQuery->where('month', $reportMonth);
        } elseif ($reportYear) {
            $listQuery->where('month', 'like', '%' . $reportYear);
        }
        if (! empty($listFilters['list_class'] ?? null)) {
            $listQuery->whereHas('student', function ($q) use ($listFilters) {
                $q->where('class_name', $listFilters['list_class']);
            });
        }
        if (! empty($listFilters['list_status'] ?? null) && in_array($listFilters['list_status'], ['PAID', 'PENDING', 'PARTIAL'], true)) {
            $listQuery->where('status', $listFilters['list_status']);
        }
        $recentFees = $listQuery->latest()->take($recentLimit)->get();

        $filterClasses = array_map('strval', range(1, 12));
        $filterYears = range((int) date('Y') + 1, (int) date('Y') - 10);

        $filterMonths = [];
        $selectedYear = $reportYear ? (int) $reportYear : (int) date('Y');
        foreach (range(1, 12) as $m) {
            $d = Carbon::createFromDate($selectedYear, $m, 1);
            $filterMonths[$d->format('F Y')] = $d->format('F Y');
        }

        return compact('studentCount', 'staffCount', 'monthlyRevenue', 'pendingFees', 'recentFees', 'filterClasses', 'filterYears', 'filterMonths', 'reportType', 'reportYear', 'reportMonth');
    }

    public function index(Request $request)
    {
        $reportFilters = $request->only(['report_type', 'report_year', 'report_month']);
        $listFilters = $request->only(['list_year', 'list_class', 'list_status']);
        return view('dashboard', $this->getDashboardData(5, $reportFilters, $listFilters));
    }

    private function getReportChartData(array $reportFilters): array
    {
        $reportType = $reportFilters['report_type'] ?? null;
        $reportYear = $reportFilters['report_year'] ?? null;
        $reportMonth = $reportFilters['report_month'] ?? null;

        $baseQuery = Fee::query();
        if ($reportType === 'monthly' && $reportMonth !== null && $reportMonth !== '') {
            $baseQuery->where('month', $reportMonth);
        } elseif (($reportType === 'yearly' || $reportType === null) && $reportYear !== null && $reportYear !== '') {
            $baseQuery->where('month', 'like', '%' . $reportYear);
        }

        // Fee status breakdown (counts) for pie chart
        $statusCounts = (clone $baseQuery)
            ->selectRaw('status, count(*) as cnt')
            ->groupBy('status')
            ->pluck('cnt', 'status')
            ->toArray();
        $statusLabels = ['PAID' => 'Fully paid', 'PENDING' => 'Pending', 'PARTIAL' => 'Partial'];
        $chartFeeStatus = [
            'labels' => [],
            'data' => [],
            'colors' => ['#10b981', '#f59e0b', '#06b6d4'],
        ];
        foreach (['PAID', 'PENDING', 'PARTIAL'] as $s) {
            $chartFeeStatus['labels'][] = $statusLabels[$s] ?? $s;
            $chartFeeStatus['data'][] = (int) ($statusCounts[$s] ?? 0);
        }

        // Revenue by class (bar) – sum paid_amount grouped by student class
        $revenueByClass = (clone $baseQuery)
            ->join('students', 'fees.student_id', '=', 'students.id')
            ->selectRaw('students.class_name as class_name, COALESCE(SUM(fees.paid_amount), 0) as total')
            ->groupBy('students.class_name')
            ->get()
            ->sortBy(fn ($r) => (int) $r->class_name)
            ->values();
        $classes = $revenueByClass->pluck('class_name')->map(fn ($c) => 'Class ' . $c)->values()->toArray();
        $chartRevenueByClass = [
            'labels' => $classes ?: array_map(fn ($n) => 'Class ' . $n, range(1, 12)),
            'data' => $revenueByClass->pluck('total')->map(fn ($v) => round((float) $v, 2))->values()->toArray(),
        ];
        if (empty($chartRevenueByClass['data'])) {
            $chartRevenueByClass['data'] = array_fill(0, count($chartRevenueByClass['labels']), 0);
        }

        // Revenue by month (bar) – for yearly report only, sum paid_amount per fee.month
        $chartRevenueByMonth = ['labels' => [], 'data' => []];
        if ($reportYear) {
            $monthOrder = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $revenueByMonth = (clone $baseQuery)
                ->selectRaw('month, COALESCE(SUM(paid_amount), 0) as total')
                ->groupBy('month')
                ->get()
                ->keyBy('month');
            foreach ($monthOrder as $m) {
                $key = $m . ' ' . $reportYear;
                $chartRevenueByMonth['labels'][] = $m;
                $chartRevenueByMonth['data'][] = $revenueByMonth->has($key) ? round((float) $revenueByMonth[$key]->total, 2) : 0;
            }
        }

        return [
            'chartFeeStatus' => $chartFeeStatus,
            'chartRevenueByClass' => $chartRevenueByClass,
            'chartRevenueByMonth' => $chartRevenueByMonth,
        ];
    }

    public function report(Request $request)
    {
        $reportFilters = $request->only(['report_type', 'report_year', 'report_month']);
        $data = $this->getDashboardData(10, $reportFilters, []);
        $data = array_merge($data, $this->getReportChartData($reportFilters));
        return view('dashboard.report', $data);
    }

    public function export(Request $request): Response
    {
        $reportFilters = $request->only(['report_type', 'report_year', 'report_month']);
        $data = $this->getDashboardData(10, $reportFilters, []);
        $csv = "Dashboard Summary\n";
        $csv .= "Generated," . now()->format('Y-m-d H:i') . "\n";
        $csv .= "Total Students," . $data['studentCount'] . "\n";
        $csv .= "Active Staff," . $data['staffCount'] . "\n";
        $csv .= "Monthly Revenue (Paid)," . $data['monthlyRevenue'] . "\n";
        $csv .= "Pending Fees," . $data['pendingFees'] . "\n\n";
        $csv .= "Recent Fee Collections\n";
        $csv .= "Student,Class,Total,Paid,Remaining,Status,Date\n";
        foreach ($data['recentFees'] as $fee) {
            $student = $fee->student;
            $class = ($student ? $student->class_name . ($student->section ? '-' . $student->section : '') : '—');
            $csv .= '"' . ($student->name ?? '—') . '",' . $class . ',' . $fee->amount . ',' . ($fee->paid_amount ?? 0) . ',' . $fee->pending_amount . ',' . $fee->status_label . ',' . ($fee->paid_date ? $fee->paid_date->format('Y-m-d') : '') . "\n";
        }

        return ResponseFacade::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="dashboard-report-' . date('Y-m-d') . '.csv"',
        ]);
    }
}
