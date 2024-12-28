<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // Ajouter une nouvelle catégorie
    public function addCategorie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        // Créer la catégorie
        $categorie = Categorie::create([
            'nom' => $request->nom,
        ]);

        return response()->json([
            'message' => 'Catégorie ajoutée avec succès!',
            'categorie' => $categorie
        ], 201);
    }

    // Récupérer toutes les catégories
    public function getAllCategories()
    {
        $categories = Categorie::all();
        return response()->json([
            'categories' => $categories
        ], 200);
    }

    // Supprimer une catégorie
    public function deleteCategorie($id)
    {
        $categorie = Categorie::find($id);

        if (!$categorie) {
            return response()->json([
                'message' => 'Catégorie non trouvée'
            ], 404);
        }

        $categorie->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès'
        ], 200);
    }
}
