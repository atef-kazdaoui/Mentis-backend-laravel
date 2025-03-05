<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Validator;

class RendezVousController extends Controller
{
    public function ajouterRendezVous(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'menthor_id' => 'required|exists:menthors,id',
            'menthorer_id' => 'required|exists:menthorers,id',
            'date_heure' => 'required|date|after:now',
            'duree' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Vérifier si le mentor est déjà occupé à cette date et heure
        $dateHeure = $request->date_heure;
        $menthorId = $request->menthor_id;
        $duree = $request->duree;

        $rendezVousExistant = RendezVous::where('menthor_id', $menthorId)
            ->where(function ($query) use ($dateHeure, $duree) {
                $query->whereBetween('date_heure', [$dateHeure, date('Y-m-d H:i:s', strtotime($dateHeure) + ($duree * 60))])
                      ->orWhereRaw('? BETWEEN date_heure AND DATE_ADD(date_heure, INTERVAL duree MINUTE)', [$dateHeure]);
            })
            ->exists();

        if ($rendezVousExistant) {
            return response()->json([
                'message' => 'Le mentor a déjà un rendez-vous à cette heure-là.'
            ], 409);
        }

        // Création du rendez-vous
        $rendezVous = RendezVous::create([
            'menthor_id' => $menthorId,
            'menthorer_id' => $request->menthorer_id,
            'date_heure' => $dateHeure,
            'duree' => $duree,
        ]);

        return response()->json([
            'message' => 'Rendez-vous ajouté avec succès',
            'rendez_vous' => $rendezVous
        ], 201);
    }
}
