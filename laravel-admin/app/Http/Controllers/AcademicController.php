<?php

namespace App\Http\Controllers;

use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class AcademicController extends Controller
{
    public function index(Request $request): View
    {
        $query = Result::with('student');

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->whereHas('student', function ($qry) use ($q) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(roll_number) LIKE ?', [$q]);
            });
        }

        if ($request->filled('exam')) {
            $query->where('exam_name', $request->exam);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        $results = $query->latest()->paginate(15);
        $examTypes = Result::distinct()->pluck('exam_name');

        return view('academics.index', compact('results', 'examTypes'));
    }

    public function create(): View
    {
        $students = Student::orderBy('class_name')->orderBy('name')->get();
        $examNames = Result::distinct()->pluck('exam_name')->sort()->values();
        $subjects = ['Mathematics', 'Science', 'English', 'Social Studies', 'Hindi', 'Computer', 'Physics', 'Chemistry', 'Biology', 'Other'];

        return view('academics.create', compact('students', 'examNames', 'subjects'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'exam_name' => ['required', 'string', 'max:255'],
            'subjects' => ['required', 'array', 'min:1'],
            'subjects.*.subject' => ['nullable', 'string', 'max:255'],
            'subjects.*.marks' => ['nullable', 'numeric', 'min:0'],
            'subjects.*.total_marks' => ['nullable', 'numeric', 'min:0'],
        ]);

        $studentId = (int) $validated['student_id'];
        $examName = $validated['exam_name'];
        $saved = 0;

        foreach ($validated['subjects'] as $row) {
            $subject = trim($row['subject'] ?? '');
            if ($subject === '') {
                continue;
            }
            $marks = isset($row['marks']) && is_numeric($row['marks']) ? (float) $row['marks'] : null;
            $totalMarks = isset($row['total_marks']) && is_numeric($row['total_marks']) ? (float) $row['total_marks'] : null;
            if ($totalMarks === null || $totalMarks <= 0) {
                continue;
            }

            Result::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'exam_name' => $examName,
                    'subject' => $subject,
                ],
                [
                    'marks' => $marks ?? 0,
                    'total_marks' => $totalMarks,
                ]
            );
            $saved++;
        }

        if ($saved === 0) {
            return redirect()->back()->withInput()->with('error', 'Please enter at least one subject with marks and total marks.');
        }

        return redirect()->route('admin.academics.index')
            ->with('success', 'Marks recorded successfully.');
    }

    public function report(Result $result): View
    {
        $result->load('student');
        $examResults = Result::where('student_id', $result->student_id)
            ->where('exam_name', $result->exam_name)
            ->orderBy('subject')
            ->get();

        return view('academics.report', [
            'student' => $result->student,
            'examName' => $result->exam_name,
            'results' => $examResults,
        ]);
    }

    public function importForm(): View
    {
        return view('academics.import');
    }

    public function importTemplate()
    {
        $csv = "roll_number,exam_name,subject,marks,total_marks\n";
        $csv .= "2024001,Mid-Term 2025,Mathematics,85,100\n";
        $csv .= "2024001,Mid-Term 2025,Science,78,100\n";
        $csv .= "2024002,Mid-Term 2025,Mathematics,92,100\n";

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="marks-import-template.csv"',
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
            return redirect()->route('admin.academics.import')->with('error', 'Could not read the file.');
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return redirect()->route('admin.academics.import')->with('error', 'File is empty.');
        }

        $header = array_map('trim', array_map('strtolower', $header));
        $rollIndex = array_search('roll_number', $header);
        $examIndex = array_search('exam_name', $header);
        $subjectIndex = array_search('subject', $header);
        $marksIndex = array_search('marks', $header);
        $totalIndex = array_search('total_marks', $header);

        if ($rollIndex === false || $examIndex === false || $subjectIndex === false || $marksIndex === false || $totalIndex === false) {
            fclose($handle);
            return redirect()->route('admin.academics.import')->with('error', 'CSV must have columns: roll_number, exam_name, subject, marks, total_marks (first row = headers).');
        }

        $created = 0;
        $updated = 0;
        $errors = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < 5) {
                continue;
            }
            $rollNumber = trim($row[$rollIndex] ?? '');
            $examName = trim($row[$examIndex] ?? '');
            $subject = trim($row[$subjectIndex] ?? '');
            $marks = is_numeric($row[$marksIndex] ?? '') ? (float) $row[$marksIndex] : null;
            $totalMarks = is_numeric($row[$totalIndex] ?? '') ? (float) $row[$totalIndex] : null;

            if ($rollNumber === '' || $examName === '' || $subject === '' || $marks === null || $totalMarks === null || $totalMarks <= 0) {
                continue;
            }

            $student = Student::where('roll_number', $rollNumber)->first();
            if (! $student) {
                $errors[] = "Roll number \"{$rollNumber}\" not found.";
                continue;
            }

            $existing = Result::where('student_id', $student->id)->where('exam_name', $examName)->where('subject', $subject)->first();
            if ($existing) {
                $existing->update(['marks' => $marks, 'total_marks' => $totalMarks]);
                $updated++;
            } else {
                Result::create([
                    'student_id' => $student->id,
                    'exam_name' => $examName,
                    'subject' => $subject,
                    'marks' => $marks,
                    'total_marks' => $totalMarks,
                ]);
                $created++;
            }
        }

        fclose($handle);

        $message = "Imported: {$created} new, {$updated} updated.";
        if (count($errors) > 0) {
            $message .= ' Errors: ' . implode(' ', array_slice($errors, 0, 5));
            if (count($errors) > 5) {
                $message .= ' (+' . (count($errors) - 5) . ' more)';
            }
        }

        return redirect()->route('admin.academics.index')->with(count($errors) > 0 ? 'warning' : 'success', $message);
    }
}
