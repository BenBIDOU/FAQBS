<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceDonorRestrictionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Tous les utilisateurs connectés peuvent accéder aux pages internes
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        return $next($request);
    }
}
