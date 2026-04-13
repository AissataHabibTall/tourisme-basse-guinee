<?php

namespace App\Policies;

use App\Models\Utilisateur;

class GuideTouristiquePolicy
{
    /**
     * Détermine si l'utilisateur peut voir la liste des guides.
     */
    public function viewAny(Utilisateur $utilisateur): bool
    {
        return true; // Tous les utilisateurs peuvent voir la liste
    }

    /**
     * Détermine si l'utilisateur peut voir les détails d'un guide.
     */
    public function view(Utilisateur $utilisateur, $guide): bool
    {
        return true; // Tous les utilisateurs peuvent voir un guide
    }

    /**
     * Détermine si l'utilisateur peut créer un guide.
     */
    public function create(Utilisateur $utilisateur): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour un guide.
     */
    public function update(Utilisateur $utilisateur, $guide): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut supprimer un guide.
     */
    public function delete(Utilisateur $utilisateur, $guide): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut restaurer un guide.
     */
    public function restore(Utilisateur $utilisateur, $guide): bool
    {
        return $utilisateur->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut forcer la suppression d'un guide.
     */
    public function forceDelete(Utilisateur $utilisateur, $guide): bool
    {
        return $utilisateur->role === 'admin';
    }
}
