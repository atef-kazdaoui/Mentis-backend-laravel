<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckMenthorOrMenthorerAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        // Récupérer le rôle de l'utilisateur
        $userRole = Auth::user()->role;

        // Vérifier si l'utilisateur a l'un des rôles autorisés (Menthor ou Menthorer)
        if ($userRole !== 'menthor' && $userRole !== 'menthorer') {
            return response()->json(['error' => 'Accès interdit'], 403);
        }

        // Si l'utilisateur a un rôle valide (Menthor ou Menthorer), passer à la requête suivante
        return $next($request);
    }
}
