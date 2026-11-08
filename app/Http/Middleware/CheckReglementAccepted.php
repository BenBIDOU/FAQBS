<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckReglementAccepted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté et n'a pas accepté le règlement
        if (auth()->check() && !auth()->user()->has_accepted_reglement) {
            // Ne pas rediriger si l'utilisateur est déjà sur la page d'acceptation ou sur le règlement
            if (!$request->is('accept-reglement') && !$request->is('reglement') && 
                $request->route()->getName() !== 'accept.reglement.page' &&
                $request->route()->getName() !== 'accept.reglement') {
                return redirect()->route('accept.reglement.page');
            }
        }
        
        return $next($request);
    }
}
