<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $fillable = [
        'menthor_id',
        'menthorer_id',
        'date_heure',
        'duree',
    ];

    public function menthor()
    {
        return $this->belongsTo(Menthor::class);
    }

    public function menthorer()
    {
        return $this->belongsTo(Menthorer::class);
    }
}