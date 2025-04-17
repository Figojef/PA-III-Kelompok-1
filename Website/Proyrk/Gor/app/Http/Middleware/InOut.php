<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class InOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if(!Session::has('jwt') || Session::get('user_data')['role'] !== 'admin'){
        //     return abort(403);
        // }
        if(Session::has('jwt')){
            if(Session::get('user_data')['role'] == 'admin'){
                return redirect()->route('admin');
            }else{
                return redirect()->route('dashboard');
            }
        }
        return $next($request);
    }
}
