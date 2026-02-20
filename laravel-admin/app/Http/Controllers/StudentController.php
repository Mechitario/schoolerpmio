<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Response;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->where(function ($qry) use ($q) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(roll_number) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(class_name) LIKE ?', [$q]);
            });
        }

        if ($request->filled('class') && $request->class !== 'All') {
            $classVal = (string) $request->class;
            $query->where(function ($q) use ($classVal) {
                $q->where('class_name', $classVal)
                    ->orWhere('class_name', $classVal . 'th');
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $students = $query->latest()->paginate(15);

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        $parents = \App\Models\Guardian::orderBy('name')->get();
        return view('students.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roll_number' => ['required', 'string', 'max:255', 'unique:students,roll_number'],
            'class_name' => ['required', 'string', 'in:1,2,3,4,5,6,7,8,9,10,11,12'],
            'section' => ['nullable', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'parent_id' => ['nullable', 'integer', 'exists:parents,id'],
        ], [
            'roll_number.unique' => 'This roll number is already in use.',
            'class_name.in' => 'Please select a class from 1 to 12.',
        ]);

        $validated['year'] = (int) $validated['year'];
        $validated['parent_id'] = $validated['parent_id'] ?? null;
        Student::create($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student added successfully.');
    }

    public function edit(Student $student): View
    {
        $parents = \App\Models\Guardian::orderBy('name')->get();
        return view('students.edit', compact('student', 'parents'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'roll_number' => ['required', 'string', 'max:255', 'unique:students,roll_number,' . $student->id],
            'class_name' => ['required', 'string', 'in:1,2,3,4,5,6,7,8,9,10,11,12'],
            'section' => ['nullable', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'parent_id' => ['nullable', 'integer', 'exists:parents,id'],
        ], [
            'roll_number.unique' => 'This roll number is already in use.',
            'class_name.in' => 'Please select a class from 1 to 12.',
        ]);

        $validated['year'] = (int) $validated['year'];
        $validated['parent_id'] = $validated['parent_id'] ?? null;
        $student->update($validated);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function importForm(): View
    {
        return view('students.import');
    }

    public function importTemplate()
    {
        $currentYear = (int) date('Y');
        $csv = "name,roll_number,class_name,section,year\n";
        $csv .= "John Doe,2024001,10,A,{$currentYear}\n";
        $csv .= "Jane Smith,2024002,11,B,{$currentYear}\n";

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="student-import-template.csv"',
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
            return redirect()->route('admin.students.import')->with('error', 'Could not read the file.');
        }

        $header = fgetcsv($handle);
        if ($header === false) {
            fclose($handle);
            return redirect()->route('admin.students.import')->with('error', 'File is empty.');
        }

        $header = array_map('trim', array_map('strtolower', $header));
        $nameIndex = array_search('name', $header);
        $rollIndex = array_search('roll_number', $header);
        $classIndex = array_search('class_name', $header);
        $sectionIndex = array_search('section', $header);
        $yearIndex = array_search('year', $header);

        if ($nameIndex === false || $rollIndex === false || $classIndex === false) {
            fclose($handle);
            return redirect()->route('admin.students.import')->with('error', 'CSV must have columns: name, roll_number, class_name (first row = headers). Optionally: section, year.');
        }

        $imported = 0;
        $skipped = [];
        $rowNum = 1;
        $currentYear = (int) date('Y');
        $validClasses = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            $name = trim($row[$nameIndex] ?? '');
            $rollNumber = trim($row[$rollIndex] ?? '');
            $classRaw = trim($row[$classIndex] ?? '');
            $section = ($sectionIndex !== false && isset($row[$sectionIndex])) ? trim($row[$sectionIndex]) : null;
            if ($section === '') {
                $section = null;
            }
            $year = $currentYear;
            if ($yearIndex !== false && isset($row[$yearIndex]) && $row[$yearIndex] !== '') {
                $year = (int) preg_replace('/[^0-9]/', '', $row[$yearIndex]);
                if ($year < 2000 || $year > 2100) {
                    $year = $currentYear;
                }
            }

            if ($name === '' || $rollNumber === '') {
                $skipped[] = "Row {$rowNum}: missing name or roll_number";
                continue;
            }

            $classVal = preg_replace('/[^0-9]/', '', $classRaw);
            if ($classVal === '') {
                $classVal = in_array($classRaw, $validClasses) ? $classRaw : null;
            }
            if (! $classVal || ! in_array($classVal, $validClasses, true)) {
                $skipped[] = "Row {$rowNum}: class must be 1–12 (got \"{$classRaw}\")";
                continue;
            }

            if (Student::where('roll_number', $rollNumber)->exists()) {
                $skipped[] = "Row {$rowNum}: roll number \"{$rollNumber}\" already exists";
                continue;
            }

            Student::create([
                'name' => $name,
                'roll_number' => $rollNumber,
                'class_name' => $classVal,
                'section' => $section ?: null,
                'year' => $year,
            ]);
            $imported++;
        }
        fclose($handle);

        $message = "Bulk import complete: {$imported} student(s) added.";
        if (count($skipped) > 0) {
            $message .= ' Skipped: ' . implode('; ', array_slice($skipped, 0, 5));
            if (count($skipped) > 5) {
                $message .= ' (+' . (count($skipped) - 5) . ' more)';
            }
        }

        return redirect()->route('admin.students.index')->with('success', $message);
    }

    public function export(Request $request)
    {
        $query = Student::query();

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->where(function ($qry) use ($q) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(roll_number) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(class_name) LIKE ?', [$q]);
            });
        }

        if ($request->filled('class') && $request->class !== 'All') {
            $classVal = (string) $request->class;
            $query->where(function ($q) use ($classVal) {
                $q->where('class_name', $classVal)
                    ->orWhere('class_name', $classVal . 'th');
            });
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $students = $query->orderBy('class_name')->orderBy('roll_number')->get();

        $csv = "Student List\n";
        $csv .= "Exported," . now()->format('Y-m-d H:i') . "\n\n";
        $csv .= "Name,Roll Number,Class,Section,Year\n";
        foreach ($students as $student) {
            $csv .= '"' . str_replace('"', '""', $student->name) . '",';
            $csv .= '"' . str_replace('"', '""', $student->roll_number) . '",';
            $csv .= '"' . str_replace('"', '""', $student->class_name) . '",';
            $csv .= '"' . str_replace('"', '""', $student->section ?? '') . '",';
            $csv .= '"' . ($student->year ?? '') . "\"\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="students-' . date('Y-m-d') . '.csv"',
        ]);
    }
}
