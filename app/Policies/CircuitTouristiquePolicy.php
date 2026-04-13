<?php

namespace App\Policies;

use App\Models\Utilisateur;
use App\Models\CircuitTouristique;
use Illuminate\Auth\Access\HandlesAuthorization;

class CircuitTouristiquePolicy
{
    use HandlesAuthorization;

    /**
     * Déterminer si l'utilisateur peut voir la liste des circuits.
     */
    public function viewAny(Utilisateur $user): bool
    {
        return true; // Tous les utilisateurs connectés peuvent voir la liste
    }

    /**
     * Déterminer si l'utilisateur peut voir un circuit.
     */
    public function view(Utilisateur $user, CircuitTouristique $circuit): bool
    {
        return true; // Tous les utilisateurs connectés peuvent voir un circuit
    }

    /**
     * Déterminer si l'utilisateur peut créer un circuit.
     */
    public function create(Utilisateur $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut mettre à jour un circuit.
     */
    public function update(Utilisateur $user, CircuitTouristique $circuit): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Déterminer si l'utilisateur peut supprimer un circuit.
     */
    public function delete(Utilisateur $user, CircuitTouristique $circuit): bool
    {
        return $user->role === 'admin';
    }
}
