<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use App\Models\LieuTouristique;
use App\Models\Reservation;
use App\Models\Event;
use App\Models\Restaurant;
use App\Models\GuideTouristique;
use App\Models\CircuitTouristique;
use App\Models\Hebergement;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUtilisateurs' => Utilisateur::count(),
            'totalLieux' => LieuTouristique::count(),
            'totalReservations' => Reservation::count(),
            'totalEvents' => Event::count(),
            'totalRestaurants' => Restaurant::count(),
            'totalGuides' => GuideTouristique::count(),
            'totalCircuits' => CircuitTouristique::count(),
            'totalHebergements' => Hebergement::count(),
        ]);
    }
}
