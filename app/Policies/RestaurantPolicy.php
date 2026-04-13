<?php

namespace App\Policies;

use App\Models\Restaurant;
use App\Models\Utilisateur;

class RestaurantPolicy
{
    public function viewAny(?Utilisateur $utilisateur = null)
    {
        return true; // Autorisé même sans être connecté
    }

    public function view(?Utilisateur $utilisateur = null, Restaurant $restaurant)
    {
        return true;
    }

    public function create(Utilisateur $utilisateur)
    {
        return $utilisateur->role === 'admin';
    }

    public function update(Utilisateur $utilisateur, Restaurant $restaurant)
    {
        return $utilisateur->role === 'admin';
    }

    public function delete(Utilisateur $utilisateur, Restaurant $restaurant)
    {
        return $utilisateur->role === 'admin';
    }
}
