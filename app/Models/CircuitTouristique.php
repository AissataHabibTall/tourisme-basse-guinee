<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CircuitTouristique extends Model
{
    use HasFactory;

    protected $table = 'circuit_touristiques';

    protected $fillable = [
        'nom',
        'description',
        'durée',
        'prix',
        'dateDebut',
        'dateFin',
        'statut',
        'image',
    ];
}
