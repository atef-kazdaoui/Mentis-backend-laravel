<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMenthorAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        // Vérifier si l'utilisateur est un Menthor
        if (Auth::user()->role !== 'menthor') {
            return response()->json(['error' => 'Accès interdit, vous devez être un Menthor'], 403);
        }

        // Si l'utilisateur est un Menthor, passer à la requête suivante
        return $next($request);
    }
}
