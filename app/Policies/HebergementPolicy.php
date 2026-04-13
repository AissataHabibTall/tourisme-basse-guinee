<?php

namespace App\Policies;

use App\Models\Hebergement;
use App\Models\Utilisateur;

class HebergementPolicy
{
    /**
     * Déterminer si l'utilisateur peut voir la liste des hébergements.
     */
    public function viewAny(Utilisateur $utilisateur): bool
    {
        return true; // Tous les utilisateurs peuvent voir
    }

    /**
     * Déterminer si l'utilisateur peut voir un hébergement.
     */
    public function view(Utilisateur $utilisateur, Hebergement $hebergement): bool
    {
        return true; // Tous les utilisateurs peuvent voir
    }

    /**
     * Déterminer si l'utilisateur peut créer un hébergement.
     */
    public function create(Utilisateur $utilisateur): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour un hébergement.
     */
    public function update(Utilisateur $utilisateur, Hebergement $hebergement): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un hébergement.
     */
    public function delete(Utilisateur $utilisateur, Hebergement $hebergement): bool
    {
        return $utilisateur->role === 'admin';
    }
}
