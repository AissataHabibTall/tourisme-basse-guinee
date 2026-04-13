<?php

namespace App\Policies;

use App\Models\LieuTouristique;
use App\Models\Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class LieuTouristiquePolicy
{
    use HandlesAuthorization;

    /**
     * Tout utilisateur connecté peut voir la liste.
     */
    public function viewAny(?Utilisateur $user): bool
    {
        // Le middleware "auth" garantit qu'on a un $user,
        // mais on accepte aussi null si jamais.
        return true;
    }

    /**
     * Tout utilisateur connecté peut voir un lieu.
     */
    public function view(?Utilisateur $user, LieuTouristique $lieuTouristique): bool
    {
        return true;
    }

    /**
     * Seul l'admin peut créer.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul l'admin peut modifier.
     */
    public function update(Utilisateur $user, LieuTouristique $lieuTouristique): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seul l'admin peut supprimer.
     */
    public function delete(Utilisateur $user, LieuTouristique $lieuTouristique): bool
    {
        return $user->role === 'admin';
    }
}
