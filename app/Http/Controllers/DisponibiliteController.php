<?php

namespace App\Http\Controllers;

use App\Models\Disponibilite;
use App\Models\Menthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
class DisponibiliteController extends Controller
{
    // Méthode pour ajouter une disponibilité
    public function store(Request $request, $menthorId)
    {
         // Validation des données de la disponibilité
    $validator = Validator::make($request->all(), [
        'jour' => 'required|string|max:255',
        'heure_debut' => 'required|date_format:H:i',
        'heure_fin' => 'required|date_format:H:i|after:heure_debut',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Créer une nouvelle disponibilité pour le Menthor
    $disponibilite = new Disponibilite();
    $disponibilite->menthor_id = 1; // ID du Menthor (ajuste selon ton cas)
    $disponibilite->jour = $request->jour;
    $disponibilite->heure_debut = $request->heure_debut;
    $disponibilite->heure_fin = $request->heure_fin;

    // Enregistrement dans la base de données
    $disponibilite->save();

    return response()->json([
        'message' => 'Disponibilité ajoutée avec succès!',
        'disponibilite' => $disponibilite,
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
