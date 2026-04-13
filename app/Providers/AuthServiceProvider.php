<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Restaurant;
use App\Policies\RestaurantPolicy;
use App\Models\Event;
use App\Policies\EventPolicy;
use App\Models\Reservation;
use App\Policies\ReservationPolicy;
use App\Models\Utilisateur;
use App\Policies\UtilisateurPolicy;
use App\Models\GuideTouristique;
use App\Policies\GuideTouristiquePolicy;
use App\Models\Hebergement;
use App\Policies\HebergementPolicy;
use App\Models\Avis;
use App\Policies\AvisPolicy;
use App\Models\CircuitTouristique;
use App\Policies\CircuitTouristiquePolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Le tableau des policies pour ton application.
     *
     * @var array
     */
    protected $policies = [
        Restaurant::class => RestaurantPolicy::class,
        Event::class => EventPolicy::class,
        Reservation::class => ReservationPolicy::class,
        Utilisateur::class => UtilisateurPolicy::class,
        GuideTouristique::class => GuideTouristiquePolicy::class,
        Hebergement::class => HebergementPolicy::class,
    ];

    /**
     * Enregistre les services d'autorisation.
     */
    public function boot()
{
    $this->registerPolicies();

    Gate::define('view-admin-section', function (Utilisateur $utilisateur) {
        return $utilisateur->role === 'admin';
    });
}
}
