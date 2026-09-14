<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceDonorRestrictionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Autoriser tous les utilisateurs connectés à ajouter des discussions
        // (Les Masters, Donneurs de Voix, Présidents, et autres peuvent tous créer des discussions)
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        return $next($request);
    }
}
