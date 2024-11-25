<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request; // Gunakan ini
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        return redirect('/');
    }
}
