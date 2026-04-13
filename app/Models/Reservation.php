<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'utilisateur_id',
        'element_type',
        'element_id',
        'date_debut',
        'date_fin',
        'statut',
    ];

    // ✅ Relation avec l'utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    // ✅ Relation polymorphique
    public function element()
    {
        return $this->morphTo(__FUNCTION__, 'element_type', 'element_id');
    }

    // Relations directes supplémentaires
    public function hebergement()
    {
        return $this->belongsTo(Hebergement::class, 'element_id');
    }

    public function guide()
    {
        return $this->belongsTo(GuideTouristique::class, 'element_id');
    }

    public function circuit()
    {
        return $this->belongsTo(CircuitTouristique::class, 'element_id');
    }

    public function lieu()
    {
        return $this->belongsTo(LieuTouristique::class, 'element_id');
    }

    protected static function booted()
    {
        static::retrieved(function ($reservation) {
            if ($reservation->element_type && !str_contains($reservation->element_type, '\\')) {
                $map = [
                    'hebergement' => \App\Models\Hebergement::class,
                    'guide'       => \App\Models\GuideTouristique::class,
                    'circuit'     => \App\Models\CircuitTouristique::class,
                    'lieu'        => \App\Models\LieuTouristique::class,
                ];

                if (isset($map[$reservation->element_type])) {
                    $reservation->element_type = $map[$reservation->element_type];
                }
            }
        });
    }
}
