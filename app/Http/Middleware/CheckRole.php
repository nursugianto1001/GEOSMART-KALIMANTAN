<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        if ($user->role !== $role) {
            abort(403, 'Unauthorized access');
        }

        if (!$user->is_active) {
            Auth::logout();
            return redirect('/login')->with('error', 'Akun Anda telah dinonaktifkan');
        }

        return $next($request);
    }
}
