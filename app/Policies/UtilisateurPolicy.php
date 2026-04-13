<?php

namespace App\Policies;

use App\Models\Utilisateur;
use Illuminate\Auth\Access\HandlesAuthorization;

class UtilisateurPolicy
{
    use HandlesAuthorization;

    /**
     * Détermine si l'utilisateur peut voir la liste des utilisateurs (index).
     * Seul l'admin peut.
     */
    public function viewAny(Utilisateur $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut voir un utilisateur spécifique.
     * L'admin peut voir tous, un utilisateur peut voir son propre profil.
     */
    public function view(Utilisateur $user, Utilisateur $model)
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }

    /**
     * Détermine si l'utilisateur peut créer un utilisateur.
     * Seul l'admin peut.
     */
    public function create(Utilisateur $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Détermine si l'utilisateur peut modifier un utilisateur.
     * L'admin peut modifier tous, un utilisateur peut modifier son propre profil.
     */
    public function update(Utilisateur $user, Utilisateur $model)
    {
        return $user->role === 'admin' || $user->id === $model->id;
    }

    /**
     * Détermine si l'utilisateur peut supprimer un utilisateur.
     * Seul l'admin peut.
     */
    public function delete(Utilisateur $user, Utilisateur $model)
    {
        return $user->role === 'admin';
    }
}
