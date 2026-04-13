<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';

    protected $fillable = [
        'nom',
        'specialites',
        'adresse',
        'tarifMoyen',
        'contact',
        'noteMoyenne',
        'image_url', // pour l’image principale
        'galerie_images_restaurant', // nouveau champ pour la galerie
    ];

    protected $casts = [
        'galerie_images_restaurant' => 'array',
    ];
}
