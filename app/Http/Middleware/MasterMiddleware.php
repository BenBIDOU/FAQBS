<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->is_master) {
            return redirect('/')->with('error', 'Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
        }

        return $next($request);
    }
}
