<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menthor extends Model
{
    use HasFactory;

    // Définit les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'password',
        'numero_siret',
        'score',
        'commentaire',
        'annee_experience'
    ];

    // Définir les relations avec d'autres modèles, si nécessaire
    // Par exemple, un Menthor peut avoir plusieurs Menthorers (relation 1:n)
    public function menthorers()
    {
        return $this->hasMany(Menthorer::class);
    }

    // Méthode pour sécuriser l'authentification, en utilisant le mot de passe haché
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}