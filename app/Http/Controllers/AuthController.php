<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menthor;
use App\Models\Menthorer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Validation\Rules\Password;


class AuthController extends Controller
{
    //******** Inscription Menthor
    public function registerMenthor(Request $request)
    {
        $validator = Validator::make($request->all(), [
    'nom' => 'required|string|max:255',
    'prenom' => 'required|string|max:255',
    'email' => 'required|email|unique:menthors,email',
    'password' => [
        'required',
        'string',
        'confirmed',
        Password::min(8) // longueur minimale
            ->mixedCase() // majuscule + minuscule
            ->letters()   // contient lettres
            ->numbers()   // contient chiffres
            ->symbols()   // contient symbole
            ->uncompromised() // vérifie si le mot de passe est connu (pwned passwords)
    ],
    'numero_siret' => 'required|string|max:14',
    'score' => '0',
    'commentaire' => '',
    'annee_experience' => 'nullable|numeric',
]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
    
        // Créer le mentor
        try {
            $menthor = Menthor::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'numero_siret' => $request->numero_siret,
                'score' => $request->score ?? 0,
                'commentaire' => $request->commentaire ?? '',
                'annee_experience' => $request->annee_experience ?? 0,
            ]);
            return response()->json(['message' => 'Menthor created successfully!', 'menthor' => $menthor], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la création du mentor', 'details' => $e->getMessage()], 500);
        }
    }
    //***********inscription menthorer 

    public function registerMenthorer(Request $request)
{
    // Validation des données
    $validator = Validator::make($request->all(), [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:menthorers',
        'password' => [
            'required',
            'string',
            'confirmed', 
            Password::min(8)               // Minimum 8 caractères
                ->mixedCase()              // Doit contenir des majuscules et minuscules
                ->numbers()                // Doit contenir au moins un chiffre
                ->symbols(),               // Doit contenir un caractère spécial
        ],
    ]);
    
    // Vérification des erreurs
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Création du Menthorer
    $menthorer = Menthorer::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'email' => $request->email,
        'password' => $request->password, // Hashé automatiquement grâce au mutator dans le modèle
    ]);

    return response()->json([
        'message' => 'Inscription réussie',
        'menthorer' => $menthorer
    ], 201);
}
    
    // ******************* connexion menthorer
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
    
        // Recherche de l'utilisateur
        $menthorer = Menthorer::where('email', $request->email)->first();
    
        // Vérification si l'utilisateur existe
        if (!$menthorer) {
            return response()->json(['message' => 'Email non trouvé'], 404);
        }
    
        $password1=bcrypt($request->password);

        // Vérification du mot de passe
        if  ( $password1 == $menthorer->password) {
            return response()->json(['message' => 'Mot de passe incorrect'], 401);
        }
    
        // Génération du token JWT
        $CLE_SECURITE = env('CLE_SECURITE');

        $key = env('JWT_SECRET', $CLE_SECURITE); // Assurez-vous d'avoir une clé dans votre fichier .env
        $payload = [
            'id' => $menthorer->id,
            'email' => $menthorer->email,
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

    
}