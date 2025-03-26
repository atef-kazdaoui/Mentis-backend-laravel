<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentaireController extends Controller
{
   // CommentaireController.php

public function store(Request $request, $menthorer_id)
{
    $validator = Validator::make($request->all(), [
        'menthor_id' => 'required|exists:menthors,id',
        'contenu' => 'required|string|max:1000',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $commentaire = Commentaire::create([
        'menthorer_id' => $menthorer_id,  // Utilisation de l'ID du menthorer passé dans l'URL
        'menthor_id' => $request->menthor_id,
        'contenu' => $request->contenu,
    ]);

    return response()->json($commentaire, 201);
}


    // Afficher tous les commentaires avec le nom du Menthorer
    public function index()
    {
        $commentaires = Commentaire::with('menthorer:id,nom,prenom')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($commentaires);
    }
}
