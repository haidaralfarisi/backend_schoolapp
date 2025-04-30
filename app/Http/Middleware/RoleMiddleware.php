<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $levels): Response
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Ubah string level menjadi array
        $allowedLevels = array_map('trim', explode(',', strtoupper($levels)));

        // Cek apakah user memiliki salah satu level yang diizinkan
        if (!in_array(strtoupper($user->level), $allowedLevels)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}

