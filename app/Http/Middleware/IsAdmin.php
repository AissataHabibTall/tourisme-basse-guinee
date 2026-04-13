<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Vérifie que l'utilisateur connecté est un administrateur.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $utilisateur = Auth::user();

        if ($utilisateur->role !== 'admin') {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
