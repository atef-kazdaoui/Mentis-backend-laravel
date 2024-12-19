<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menthorer extends Model
{
    use HasFactory;

    // Définit les attributs qui peuvent être assignés en masse
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
    ];

    // Définir la relation avec le modèle Menthor
    // Un Menthorer appartient à un Menthor
    public function menthor()
    {
        return $this->belongsTo(Menthor::class);
    }

    // Méthode pour sécuriser l'authentification, en utilisant le mot de passe haché
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
