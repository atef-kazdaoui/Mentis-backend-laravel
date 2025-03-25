<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Menthor extends Model
{
    use HasFactory,HasApiTokens; 
    // Définit les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'numero_siret',
        'score',
        'commentaire',
        'annee_experience',
        'role',
    ];

    // Définir les relations avec d'autres modèles, si nécessaire
    // Par exemple, un Menthor peut avoir plusieurs Menthorers (relation 1:n)
    public function menthorers()
    {
        return $this->hasMany(Menthorer::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'mentor_categorie', 'menthor_id', 'categorie_id');
    }
    public function disponibilites()
    {
        return $this->hasMany(Disponibilite::class);
    }

   
}
