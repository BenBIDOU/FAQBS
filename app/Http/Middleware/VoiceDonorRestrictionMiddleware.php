<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoiceDonorRestrictionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Si l'utilisateur est un donateur de voix, il peut accéder à toutes les pages internes
        if (Auth::check() && Auth::user()->is_voice_donor) {
            $allowedPaths = [
                '/',
                '/Donneurs-Voix',
                '/faq',
                '/Secrétariat',
                '/espace-membre',
                '/Donneurs-Temps',
                '/Président',
            ];

            if (!in_array($request->getPathInfo(), $allowedPaths, true)) {
                return redirect('/')->with('error', 'Accès réservé aux membres.');
            }
        }

        return $next($request);
    }
}
