<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Guardian::query()->with('students');

        if ($request->filled('search')) {
            $q = '%' . mb_strtolower($request->search) . '%';
            $query->where(function ($qry) use ($q) {
                $qry->whereRaw('LOWER(name) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(email) LIKE ?', [$q])
                    ->orWhereRaw('LOWER(phone) LIKE ?', [$q]);
            });
        }

        $parents = $query->latest()->paginate(15);

        return view('parents.index', compact('parents'));
    }

    public function create(): View
    {
        $students = Student::orderBy('name')->get();
        $studentsForLink = $students->map(fn ($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'class_name' => $s->class_name,
            'section' => $s->section,
            'roll_number' => $s->roll_number,
        ])->values();
        return view('parents.create', compact('students', 'studentsForLink'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:parents,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:6'],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ]);

        $parentData = [
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        // Set password if provided, otherwise generate a default one
        if (!empty($validated['password'])) {
            $parentData['password'] = $validated['password'];
        } elseif (!empty($validated['email'])) {
            // Default password is 'password' if email is provided
            $parentData['password'] = 'password';
        }

        $parent = Guardian::create($parentData);

        if (!empty($validated['student_ids'])) {
            Student::whereIn('id', $validated['student_ids'])->update(['parent_id' => $parent->id]);
        }

        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent added successfully.');
    }

    public function edit(Guardian $parent): View
    {
        $parent->load('students');
        $students = Student::orderBy('name')->get();
        $studentsForLink = $students->map(fn ($s) => [
            'id' => $s->id,
            'name' => $s->name,
            'class_name' => $s->class_name,
            'section' => $s->section,
            'roll_number' => $s->roll_number,
        ])->values();
        return view('parents.edit', ['parent' => $parent, 'students' => $students, 'studentsForLink' => $studentsForLink]);
    }

    public function update(Request $request, Guardian $parent): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:parents,email,' . $parent->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:6'],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['integer', 'exists:students,id'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        // Update password only if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $parent->update($updateData);

        // Unlink all current children, then link selected ones
        $parent->students()->update(['parent_id' => null]);
        if (!empty($validated['student_ids'])) {
            Student::whereIn('id', $validated['student_ids'])->update(['parent_id' => $parent->id]);
        }

        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent updated successfully.');
    }
}
