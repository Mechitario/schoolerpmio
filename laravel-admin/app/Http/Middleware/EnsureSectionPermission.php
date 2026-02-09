<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSectionPermission
{
    public function handle(Request $request, Closure $next, string $section): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $allowed = match ($section) {
            'dashboard' => (bool) $user->can_view_dashboard,
            'users' => (bool) $user->can_view_admin_users,
            'students' => (bool) $user->can_view_students,
            'staff' => (bool) $user->can_view_staff,
            'fees' => (bool) $user->can_view_fees,
            'academics' => (bool) $user->can_view_academics,
            default => true,
        };

        if (! $allowed) {
            abort(403, 'You do not have permission to access this section.');
        }

        return $next($request);
    }
}

