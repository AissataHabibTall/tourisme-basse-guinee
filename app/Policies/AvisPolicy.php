<?php

namespace App\Policies;

use App\Models\Avis;
use App\Models\Utilisateur;

class AvisPolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des avis.
     */
    public function viewAny(Utilisateur $utilisateur): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut voir un avis.
     */
    public function view(Utilisateur $utilisateur, Avis $avis): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut créer un avis.
     */
    public function create(Utilisateur $utilisateur): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut modifier un avis.
     */
    public function update(Utilisateur $utilisateur, Avis $avis): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut supprimer un avis.
     */
    public function delete(Utilisateur $utilisateur, Avis $avis): bool
    {
        return $utilisateur->role === 'admin';
    }
}
