<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    // Attributs assignables en masse
    protected $fillable = [
        'nom',
    ];
    public function mentors()
    {
        return $this->belongsToMany(Menthor::class, 'category_menthor', 'category_id', 'menthor_id');
    }
}
