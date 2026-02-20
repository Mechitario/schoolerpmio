<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guardian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ParentLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.parent-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Try to find parent by email
        $parent = Guardian::where('email', $credentials['email'])->first();

        if (!$parent) {
            return back()->withErrors([
                'email' => __('The provided credentials do not match our records.'),
            ])->onlyInput('email');
        }

        // Check if password is set and matches
        if (!$parent->password || !Hash::check($credentials['password'], $parent->password)) {
            return back()->withErrors([
                'email' => __('The provided credentials do not match our records.'),
            ])->onlyInput('email');
        }

        // Login using parent guard
        Auth::guard('parent')->login($parent, (bool) $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->route('parent.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('parent')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('parent.login');
    }
}
