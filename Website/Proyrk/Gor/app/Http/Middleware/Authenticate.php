<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        // Cek jika token JWT tidak ada di session
        if (!Session::has('jwt') || !Session::has('user_data')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
