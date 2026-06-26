<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresidentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifie que l'utilisateur est connecté et est le président
        if (!Auth::check() || !Auth::user()->is_president) {
            return redirect('/')->with('error', 'Accès réservé au président de l\'association.');
        }

        return $next($request);
    }
}
