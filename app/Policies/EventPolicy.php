<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Utilisateur;

class EventPolicy
{
    /**
     * Autorise tous les utilisateurs à voir la liste.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return true;
    }

    /**
     * Autorise tous les utilisateurs à voir un événement.
     */
    public function view(Utilisateur $user, Event $event): bool
    {
        return true;
    }

    /**
     * Seuls les admins peuvent créer un événement.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seuls les admins peuvent modifier un événement.
     */
    public function update(Utilisateur $user, Event $event): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seuls les admins peuvent supprimer un événement.
     */
    public function delete(Utilisateur $user, Event $event): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seuls les admins peuvent restaurer un événement.
     */
    public function restore(Utilisateur $user, Event $event): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Seuls les admins peuvent forcer la suppression.
     */
    public function forceDelete(Utilisateur $user, Event $event): bool
    {
        return $user->role === 'admin';
    }
}
