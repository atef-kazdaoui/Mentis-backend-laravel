<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = ['menthorer_id', 'menthor_id', 'contenu'];

    public function menthorer()
    {
        return $this->belongsTo(Menthorer::class);
    }

    public function menthor()
    {
        return $this->belongsTo(Menthor::class);
    }
}
