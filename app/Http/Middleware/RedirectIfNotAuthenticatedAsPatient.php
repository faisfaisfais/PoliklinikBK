<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticatedAsPatient
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('pasien')->check()) {
            return redirect()->route('home'); // Redirect ke form login pasien
        }

        return $next($request);
    }
}
