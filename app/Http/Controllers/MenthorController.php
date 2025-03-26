<?php

namespace App\Http\Controllers;

use App\Models\Menthor;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
class MenthorController extends Controller
{  
       public function loginMenthor(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Recherche du Menthor
        $menthor = Menthor::where('email', $request->email)->first();
    
        // Vérification si le Menthor existe
        if (!$menthor) {
            return response()->json(['message' => 'Email non trouvé'], 404);
        }
    
        // Vérification du mot de passe
        if (!\Hash::check($request->password, $menthor->password)) {
            return response()->json(['message' => 'Mot de passe incorrect'], 401);
        }
    
        // Génération du token JWT
        $CLE_SECURITE = env('CLE_SECURITE');
        $key = env('JWT_SECRET', $CLE_SECURITE); // Assurez-vous d'avoir une clé dans votre fichier .env
        
        $payload = [
            'id' => $menthor->id,
            'email' => $menthor->email,
            'iat' => time(), // Timestamp actuel
            'exp' => time() + (60 * 60 * 24), // Expiration : 24 heures
        ];
        
        $token = JWT::encode($payload, $key, 'HS256');
    
        // Connexion réussie
        return response()->json([
            'message' => 'Connexion réussie',
            'token' => $token,
        ]);
    }




    /**
     * Associer une catégorie à un menthor.
     */
    public function addCategoryToMenthor(Request $request, $menthorId)
    {
        try {
            // Étape 1 : Valider les données envoyées
            $validated = $request->validate([
                'categorie_id' => 'required|exists:categories,id',
            ]);

            // Étape 2 : Vérifier si le menthor existe
            $menthor = Menthor::find($menthorId);

            if (!$menthor) {
                return response()->json([
                    'error' => 'Menthor non trouvé avec cet ID.',
                    'menthor_id' => $menthorId,
                ], 404);
            }

            // Étape 3 : Associer la catégorie au menthor
            $menthor->categories()->attach($validated['categorie_id']);

            // Étape 4 : Réponse de succès
            return response()->json([
                'message' => 'Catégorie associée au menthor avec succès.',
                'menthor_id' => $menthorId,
                'categorie_id' => $validated['categorie_id'],
            ], 200);
        } catch (\Throwable $e) {
            // Gérer les erreurs et journaliser
            return response()->json([
                'error' => 'Une erreur interne est survenue.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Afficher les mentors d'une catégorie spécifique.
     */
    public function getMentorsByCategory($categorieId)
    {
        try {
            // Étape 1 : Vérifier si la catégorie existe
            $categorie = Categorie::findOrFail($categorieId);

            // Étape 2 : Récupérer les mentors associés à la catégorie
            $mentors = $categorie->mentors;

            // Étape 3 : Réponse avec les mentors
            return response()->json([
                'categorie' => $categorie->nom,
                'mentors' => $mentors,
            ], 200);
        } catch (\Throwable $e) {
            // Gérer les erreurs et journaliser
            return response()->json([
                'error' => 'Une erreur interne est survenue.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        // Cherche le menthor par son ID
        $menthor = Menthor::find($id);

        if (!$menthor) {
            return response()->json(['error' => 'Menthor non trouvé'], 404);
        }

        // Supprime le menthor
        $menthor->delete();

        return response()->json(['message' => 'Menthor supprimé avec succès'], 200);
    }
}
