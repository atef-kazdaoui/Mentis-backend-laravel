<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    use HasFactory;

    protected $fillable = [
        'menthor_id',
        'jour',
        'heure_debut',
        'heure_fin',
    ];

    /**
     * Définir la relation avec le modèle Menthor
     */
    public function menthor()
    {
        return $this->belongsTo(Menthor::class);
    }
}
