<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Utilisateur extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'utilisateurs';

    /**
     * Champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role',
        'photo',
        
    ];

    /**
     * Champs cachés dans les réponses JSON
     */
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Renvoyer le bon champ de mot de passe pour l’authentification
     */
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function reservations()
{
    return $this->hasMany(\App\Models\Reservation::class, 'utilisateur_id');
}
public function guide()
{
    return $this->hasMany(GuideTouristique::class);
}

    
}
