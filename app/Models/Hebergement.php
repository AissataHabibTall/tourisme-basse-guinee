<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hebergement extends Model
{
    use HasFactory;

    protected $table = 'hebergements';

    protected $fillable = [
        'nom',
        'type',
        'adresse',
        'prixParNuit',
        'disponibilite',
        'contact',
        'noteMoyenne',
        'image_url',  // Ajout de l'image_url ici
        'galerie_images_hebergement',  // nouveau champ pour la galerie
        
    ];

    protected $casts = [
        'galerie_images_hebergement' => 'array',
    ];

    public function reservations()
{
    return $this->morphMany(Reservation::class, 'element', 'element_type', 'element_id');
}
}
