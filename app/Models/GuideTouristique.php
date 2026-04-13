<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuideTouristique extends Model
{
    use HasFactory;

    protected $table = 'guide_touristiques';

    protected $fillable = [
        'nom',
        'languesParlees',
        'zoneCouverte',
        'experience',
        'tarifJournalier',
        'contact',
        'disponibilite',
        'image_url',
        'utilisateur_id', // 🔹 Ajoute si tu veux relier au modèle Utilisateur
    ];

    // Relation polymorphe pour les réservations
    public function reservations()
    {
        return $this->morphMany(Reservation::class, 'element', 'element_type', 'element_id');
    }

    // Relation avec l'utilisateur (guide créé par un utilisateur)
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}
