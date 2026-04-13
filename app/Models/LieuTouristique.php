<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LieuTouristique extends Model
{
    use HasFactory;

    protected $table = 'lieux_touristiques';

    protected $fillable = [
        'nom',
        'description',
        'adresse',
        'type',
        'coordonneesGPS',
        'image',
        'galerie_images', // Champ JSON
        'tarifEntree',
        'horairesOuverture',
        'accessibilite',
        
    ];

     protected $casts = [
        'galerie_images' => 'array',
    ];


    
}
