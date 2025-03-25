<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdminAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        // Vérifier si l'utilisateur est un Admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Accès interdit, vous devez être un Admin'], 403);
        }

        // Si l'utilisateur est un Admin, passer à la requête suivante
        return $next($request);
    }
}
