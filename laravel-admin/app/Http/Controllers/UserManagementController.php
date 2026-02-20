<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(): View
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        $roles = ['admin', 'teacher', 'accountant', 'staff'];
        return view('users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,teacher,accountant,staff'],
            'can_view_dashboard' => ['nullable', 'boolean'],
            'can_view_admin_users' => ['nullable', 'boolean'],
            'can_view_students' => ['nullable', 'boolean'],
            'can_view_parents' => ['nullable', 'boolean'],
            'can_view_staff' => ['nullable', 'boolean'],
            'can_view_fees' => ['nullable', 'boolean'],
            'can_view_inventory' => ['nullable', 'boolean'],
            'can_view_academics' => ['nullable', 'boolean'],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            // If checkbox is unchecked, key is missing -> default to false (no access)
            'can_view_dashboard' => (bool) ($validated['can_view_dashboard'] ?? false),
            'can_view_admin_users' => (bool) ($validated['can_view_admin_users'] ?? false),
            'can_view_students' => (bool) ($validated['can_view_students'] ?? false),
            'can_view_parents' => (bool) ($validated['can_view_parents'] ?? false),
            'can_view_staff' => (bool) ($validated['can_view_staff'] ?? false),
            'can_view_fees' => (bool) ($validated['can_view_fees'] ?? false),
            'can_view_inventory' => (bool) ($validated['can_view_inventory'] ?? false),
            'can_view_academics' => (bool) ($validated['can_view_academics'] ?? false),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully. They can log in with the email and password you set.');
    }

    public function edit(User $user): View
    {
        $roles = ['admin', 'teacher', 'accountant', 'staff'];
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:admin,teacher,accountant,staff'],
            'can_view_dashboard' => ['nullable', 'boolean'],
            'can_view_admin_users' => ['nullable', 'boolean'],
            'can_view_students' => ['nullable', 'boolean'],
            'can_view_parents' => ['nullable', 'boolean'],
            'can_view_staff' => ['nullable', 'boolean'],
            'can_view_fees' => ['nullable', 'boolean'],
            'can_view_inventory' => ['nullable', 'boolean'],
            'can_view_academics' => ['nullable', 'boolean'],
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        // For updates also: unchecked -> key missing -> false
        $user->can_view_dashboard = (bool) ($validated['can_view_dashboard'] ?? false);
        $user->can_view_admin_users = (bool) ($validated['can_view_admin_users'] ?? false);
        $user->can_view_students = (bool) ($validated['can_view_students'] ?? false);
        $user->can_view_parents = (bool) ($validated['can_view_parents'] ?? false);
        $user->can_view_staff = (bool) ($validated['can_view_staff'] ?? false);
        $user->can_view_fees = (bool) ($validated['can_view_fees'] ?? false);
        $user->can_view_inventory = (bool) ($validated['can_view_inventory'] ?? false);
        $user->can_view_academics = (bool) ($validated['can_view_academics'] ?? false);
        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }
        $user->save();

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }
}
