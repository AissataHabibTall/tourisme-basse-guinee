<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avis extends Model
{
    use HasFactory;

    protected $table = 'avis';

    protected $fillable = [
        'note',
        'commentaire',
        'date',
        'utilisateur_id',
        'cible_type',
        'cible_id',
    ];

    // Relation avec l'utilisateur (le donneur d'avis)
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    // Relation polymorphique avec la cible (Lieu, Hébergement, etc.)
    public function cible()
    {
        return $this->morphTo();
    }
}
