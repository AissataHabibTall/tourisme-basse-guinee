<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'titre',
        'description',
        'date_debut',
        'date_fin',
        'lieu',
        'prix',
        'image',
        'galerie_images_event',
        
    ];
    
    protected $casts = [
        'galerie_images_event' => 'array',
    ];

}
