<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Guardian;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Fee::with(['student', 'parent']);

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->whereHas('student', function ($qry) use ($q) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(roll_number) LIKE ?', [$q]);
            });
        }

        $filterYear = $request->query('year');
        $filterMonth = $request->query('month'); // month name only (e.g. January)
        $filterStatus = $request->query('status'); // PAID, PENDING, PARTIAL

        if ($filterMonth && $filterYear) {
            $query->where('month', $filterMonth . ' ' . $filterYear);
        } elseif ($filterYear) {
            $query->where('month', 'like', '%' . $filterYear);
        } elseif ($filterMonth) {
            $query->where('month', 'like', $filterMonth . ' %');
        }

        if ($filterStatus && in_array($filterStatus, ['PAID', 'PENDING', 'PARTIAL'], true)) {
            $query->where('status', $filterStatus);
        }

        $fees = $query->latest()->paginate(15);

        $statsQuery = Fee::query();
        if ($filterMonth && $filterYear) {
            $statsQuery->where('month', $filterMonth . ' ' . $filterYear);
        } elseif ($filterYear) {
            $statsQuery->where('month', 'like', '%' . $filterYear);
        } elseif ($filterMonth) {
            $statsQuery->where('month', 'like', $filterMonth . ' %');
        }
        if ($filterStatus && in_array($filterStatus, ['PAID', 'PENDING', 'PARTIAL'], true)) {
            $statsQuery->where('status', $filterStatus);
        }
        $paidThisMonth = ($filterYear || $filterMonth)
            ? (clone $statsQuery)->sum('paid_amount')
            : Fee::whereMonth('paid_date', now()->month)->whereYear('paid_date', now()->year)->sum('paid_amount');
        $pendingTotal = (float) (clone $statsQuery)->selectRaw('COALESCE(SUM(amount - paid_amount), 0) as total')->value('total');

        $filterMonths = [];
        foreach (range(1, 12) as $m) {
            $d = Carbon::createFromDate(2000, $m, 1);
            $name = $d->format('F');
            $filterMonths[$name] = $name;
        }
        $filterYears = range((int) date('Y') + 1, (int) date('Y') - 10);

        return view('fees.index', compact('fees', 'paidThisMonth', 'pendingTotal', 'filterMonths', 'filterYears'));
    }

    public function create(): View
    {
        $parents = Guardian::orderBy('name')->get();
        $students = Student::orderBy('name')->get();
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $d = Carbon::now()->subMonths($i);
            $months[$d->format('F Y')] = $d->format('F Y');
        }
        return view('fees.create', compact('parents', 'students', 'months'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:parents,id'],
            'student_id' => ['required', 'exists:students,id'],
            'month' => ['required', 'string', 'max:255'],
            'payment_date' => ['nullable', 'date'],
            'copy_fee' => ['nullable', 'numeric', 'min:0'],
            'dress_fee' => ['nullable', 'numeric', 'min:0'],
            'book_fee' => ['nullable', 'numeric', 'min:0'],
            'exam_fee' => ['nullable', 'numeric', 'min:0'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'received_amount' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'balance_carried_forward' => ['nullable', 'numeric', 'min:0'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'waived_off' => ['nullable', 'numeric', 'min:0'],
        ]);

        $copyFee = (float) ($validated['copy_fee'] ?? 0);
        $dressFee = (float) ($validated['dress_fee'] ?? 0);
        $bookFee = (float) ($validated['book_fee'] ?? 0);
        $examFee = (float) ($validated['exam_fee'] ?? 0);
        $total = $copyFee + $dressFee + $bookFee + $examFee;
        
        // received_amount = paid_amount (they are the same)
        $receivedAmount = (float) ($validated['received_amount'] ?? 0);
        $paidAmount = (float) ($validated['paid_amount'] ?? $receivedAmount);
        // Ensure they match
        $receivedAmount = $paidAmount;
        
        $waivedOff = (float) ($validated['waived_off'] ?? 0);
        $balanceCarriedForward = (float) ($validated['balance_carried_forward'] ?? 0);

        Fee::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'student_id' => $validated['student_id'],
            'month' => $validated['month'],
            'payment_date' => $validated['payment_date'] ?? null,
            'copy_fee' => $copyFee,
            'dress_fee' => $dressFee,
            'book_fee' => $bookFee,
            'exam_fee' => $examFee,
            'amount' => $total,
            'received_amount' => $receivedAmount,
            'paid_amount' => $paidAmount,
            'balance_carried_forward' => $balanceCarriedForward,
            'remarks' => $validated['remarks'] ?? null,
            'waived_off' => $waivedOff,
        ]);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee payment recorded successfully.');
    }

    public function importForm(): View
    {
        return view('fees.import');
    }

    public function importTemplate()
    {
        $csv = "roll_number,month,amount,paid_amount\n";
        $csv .= "2024001,January 2025,350.00,350.00\n";
        $csv .= "2024002,January 2025,350.00,0\n";
        $csv .= "2024003,January 2025,350.00,175.00\n";

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="fee-import-template.csv"',
        ]);
    }

    public function importProcess(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:csv,txt', 'max:2048'],
        ], [
            'file.mimes' => 'Please upload a CSV file. From Excel: File → Save As → CSV (Comma delimited).',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return redirect()->route('admin.fees.import')->with('error', 'Could not read the file.');
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return redirect()->route('admin.fees.import')->with('error', 'File is empty.');
        }

        $header = array_map('trim', array_map('strtolower', $header));
        $rollIndex = array_search('roll_number', $header);
        $monthIndex = array_search('month', $header);
        $amountIndex = array_search('amount', $header);
        $paidAmountIndex = array_search('paid_amount', $header);
        $statusIndex = array_search('status', $header);

        $hasPaidAmount = $paidAmountIndex !== false;
        $hasStatus = $statusIndex !== false;
        if ($rollIndex === false || $monthIndex === false || $amountIndex === false) {
            fclose($handle);
            return redirect()->route('admin.fees.import')->with('error', 'CSV must have columns: roll_number, month, amount. Optionally: paid_amount or status (first row = headers).');
        }

        $imported = 0;
        $updated = 0;
        $skipped = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if (count($row) < 3) {
                continue;
            }
            $rollNumber = trim($row[$rollIndex] ?? '');
            $month = trim($row[$monthIndex] ?? '');
            $amount = isset($row[$amountIndex]) ? (float) preg_replace('/[^0-9.]/', '', $row[$amountIndex]) : 0;
            $paidAmount = 0.0;
            if ($hasPaidAmount && isset($row[$paidAmountIndex])) {
                $paidAmount = (float) preg_replace('/[^0-9.]/', '', $row[$paidAmountIndex]);
            } elseif ($hasStatus && isset($row[$statusIndex])) {
                $status = strtoupper(trim($row[$statusIndex] ?? 'PENDING'));
                $paidAmount = ($status === 'PAID') ? $amount : 0;
            }
            $paidAmount = min(max(0, $paidAmount), $amount);

            if ($rollNumber === '' || $month === '') {
                $skipped[] = "Row {$rowNum}: missing roll_number or month";
                continue;
            }

            $student = Student::where('roll_number', $rollNumber)->first();
            if (! $student) {
                $skipped[] = "Row {$rowNum}: student with roll number \"{$rollNumber}\" not found";
                continue;
            }

            $existing = Fee::where('student_id', $student->id)->where('month', $month)->first();
            if ($existing) {
                $existing->update([
                    'amount' => $amount,
                    'paid_amount' => $paidAmount,
                ]);
                $updated++;
            } else {
                Fee::create([
                    'student_id' => $student->id,
                    'amount' => $amount,
                    'paid_amount' => $paidAmount,
                    'month' => $month,
                ]);
                $imported++;
            }
        }
        fclose($handle);

        $message = "Bulk import complete: {$imported} new record(s), {$updated} updated.";
        if (count($skipped) > 0) {
            $message .= ' Skipped: ' . implode('; ', array_slice($skipped, 0, 5));
            if (count($skipped) > 5) {
                $message .= ' (+' . (count($skipped) - 5) . ' more)';
            }
        }

        return redirect()->route('admin.fees.index')->with('success', $message);
    }

    public function edit(Fee $fee): View
    {
        $fee->load('student', 'parent');
        $parents = Guardian::orderBy('name')->get();
        $students = Student::orderBy('name')->get();
        $months = [];
        for ($i = 0; $i < 12; $i++) {
            $d = Carbon::now()->subMonths($i);
            $months[$d->format('F Y')] = $d->format('F Y');
        }
        return view('fees.edit', compact('fee', 'parents', 'students', 'months'));
    }

    public function update(Request $request, Fee $fee): RedirectResponse
    {
        $validated = $request->validate([
            'parent_id' => ['nullable', 'exists:parents,id'],
            'student_id' => ['required', 'exists:students,id'],
            'month' => ['required', 'string', 'max:255'],
            'payment_date' => ['nullable', 'date'],
            'copy_fee' => ['nullable', 'numeric', 'min:0'],
            'dress_fee' => ['nullable', 'numeric', 'min:0'],
            'book_fee' => ['nullable', 'numeric', 'min:0'],
            'exam_fee' => ['nullable', 'numeric', 'min:0'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'received_amount' => ['nullable', 'numeric', 'min:0'],
            'paid_amount' => ['nullable', 'numeric', 'min:0'],
            'balance_carried_forward' => ['nullable', 'numeric', 'min:0'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'waived_off' => ['nullable', 'numeric', 'min:0'],
        ]);

        $copyFee = (float) ($validated['copy_fee'] ?? 0);
        $dressFee = (float) ($validated['dress_fee'] ?? 0);
        $bookFee = (float) ($validated['book_fee'] ?? 0);
        $examFee = (float) ($validated['exam_fee'] ?? 0);
        $total = $copyFee + $dressFee + $bookFee + $examFee;
        
        // received_amount = paid_amount (they are the same)
        $receivedAmount = (float) ($validated['received_amount'] ?? 0);
        $paidAmount = (float) ($validated['paid_amount'] ?? $receivedAmount);
        // Ensure they match
        $receivedAmount = $paidAmount;
        
        $waivedOff = (float) ($validated['waived_off'] ?? 0);
        $balanceCarriedForward = (float) ($validated['balance_carried_forward'] ?? 0);

        $fee->update([
            'parent_id' => $validated['parent_id'] ?? null,
            'student_id' => $validated['student_id'],
            'month' => $validated['month'],
            'payment_date' => $validated['payment_date'] ?? null,
            'copy_fee' => $copyFee,
            'dress_fee' => $dressFee,
            'book_fee' => $bookFee,
            'exam_fee' => $examFee,
            'amount' => $total,
            'received_amount' => $receivedAmount,
            'paid_amount' => $paidAmount,
            'balance_carried_forward' => $balanceCarriedForward,
            'remarks' => $validated['remarks'] ?? null,
            'waived_off' => $waivedOff,
        ]);

        return redirect()->route('admin.fees.index')
            ->with('success', 'Fee record updated successfully.');
    }
}
