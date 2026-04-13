<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\Utilisateur;

class ReservationPolicy
{
    /**
     * L'admin peut voir toutes les réservations (liste).
     */
    public function viewAny(Utilisateur $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'admin peut voir toutes les réservations.
     * Un utilisateur peut voir uniquement ses propres réservations.
     */
    public function view(Utilisateur $user, Reservation $reservation): bool
    {
        return $user->role === 'admin' || $user->id === $reservation->utilisateur_id;
    }

    /**
     * Tous les utilisateurs peuvent créer une réservation.
     */
    public function create(Utilisateur $user): bool
    {
        return in_array($user->role, ['admin', 'utilisateur']);
    }

    /**
     * L'admin peut modifier n'importe quelle réservation.
     */
    public function update(Utilisateur $user, Reservation $reservation): bool
    {
        return $user->role === 'admin';
    }

    /**
     * L'admin peut supprimer n'importe quelle réservation.
     * Un utilisateur peut supprimer ses propres réservations.
     */
    public function delete(Utilisateur $user, Reservation $reservation): bool
    {
        return $user->role === 'admin' || $user->id === $reservation->utilisateur_id;
    }

    public function cancel(Utilisateur $user, Reservation $reservation)
{
    return $reservation->statut !== 'annulée' && $user->id === $reservation->utilisateur_id;
}
}
