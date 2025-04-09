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
        if (!Session::has('jwt')) {
            return redirect()->route('login'); // Arahkan ke halaman login
        }
        return $next($request);
    }
}
