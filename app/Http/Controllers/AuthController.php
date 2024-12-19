<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menthor;
use App\Models\Menthorer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Inscription Menthor
    public function registerMenthor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:menthors,email',
            'password' => 'required|string|min:8|confirmed',
            'numero_siret' => 'required|string|max:14',
            'score' => 'nullable|numeric',
            'commentaire' => 'nullable|string',
            'annee_experience' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $menthor = Menthor::create([
            'name' => $request->name,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'numero_siret' => $request->numero_siret,
            'score' => $request->score ?? 0,
            'commentaire' => $request->commentaire,
            'annee_experience' => $request->annee_experience ?? 0,
        ]);

        return response()->json(['message' => 'Menthor created successfully!', 'menthor' => $menthor], 201);
    }

    // Inscription Menthorer
    public function registerMenthorer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:menthorers,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        $menthorer = Menthorer::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

    
        return response()->json(['message' => 'Menthorer created successfully!', 'menthorer' => $menthorer], 201);
    }
    public function loginMenthorer(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Vérification des identifiants
        $menthorer = Menthorer::where('email', $request->email)->first();
    
        if (!$menthorer || !Hash::check($request->password, $menthorer->password)) {
            return response()->json(['message' => 'Mot de passe ou email incorrect'], 401);
        }
    
        // Succès
        return response()->json(['message' => 'Connexion réussie', 'menthorer' => $menthorer]);
    }
    
}
