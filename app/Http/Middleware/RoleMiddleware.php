<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->header('Role');

        // Cek izin akses berdasarkan metode HTTP
        if ($role === 'admin') {
            // Admin boleh melakukan semua aksi
            return $next($request);
        } elseif ($role === 'user' && $request->isMethod('get')) {
            // User hanya boleh melakukan GET
            return $next($request);
    }
    return response()->json(['error' => 'Akses ditolak. Anda tidak memiliki izin yang diperlukan.'], 403);
}
}

