<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuth
{
    public function handle($request, Closure $next)
    {
        // Cek apakah ada data user di dalam session
        if (!$request->session()->has('user')) {
            return redirect('/')->with('error', 'Unauthorized access. Please login.');
        }

        // Lanjutkan jika terdapat data user di dalam session
        return $next($request);
    }
}
