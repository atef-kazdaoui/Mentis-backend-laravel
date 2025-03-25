<?php

namespace App\Http\Controllers;

use App\Models\Disponibilite;
use App\Models\Menthor;
use Illuminate\Http\Request;

class DisponibiliteController extends Controller
{
    // Méthode pour ajouter une disponibilité
    public function store(Request $request, $menthorId)
    {
        $request->validate([
            'jour' => 'required|string|max:255',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'required|date_format:H:i|after:heure_debut', // L'heure de fin doit être après l'heure de début
        ]);

        // Crée une nouvelle disponibilité pour ce menthor
        $menthor = Menthor::find($menthorId);

        if (!$menthor) {
            return response()->json(['error' => 'Menthor non trouvé'], 404);
        }

        $disponibilite = $menthor->disponibilites()->create([
            'jour' => $request->jour,
            'heure_debut' => $request->heure_debut,
            'heure_fin' => $request->heure_fin,
        ]);

        return response()->json([
            'message' => 'Disponibilité ajoutée avec succès!',
            'disponibilite' => $disponibilite
        ], 201);
    }

    // Méthode pour récupérer les disponibilités d'un menthor
    public function index($menthorId)
    {
        $menthor = Menthor::find($menthorId);

        if (!$menthor) {
            return response()->json(['error' => 'Menthor non trouvé'], 404);
        }

        return response()->json($menthor->disponibilites);
    }

    // Méthode pour supprimer une disponibilité
    public function destroy($id)
    {
        $disponibilite = Disponibilite::find($id);

        if (!$disponibilite) {
            return response()->json(['error' => 'Disponibilité non trouvée'], 404);
        }

        $disponibilite->delete();

        return response()->json(['message' => 'Disponibilité supprimée avec succès'], 200);
    }
}
