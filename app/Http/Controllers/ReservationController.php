<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Hebergement;
use App\Models\GuideTouristique;
use App\Models\CircuitTouristique;
use App\Models\LieuTouristique;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReservationsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche la liste des réservations.
     * - Admin : toutes les réservations
     * - Guide : réservations où il est la cible ou qu'il a faites
     * - Utilisateur simple : uniquement ses réservations
     */
    public function index(Request $request)
    {
        $utilisateur = Auth::user();

        $query = Reservation::with(['utilisateur', 'hebergement', 'guide', 'circuit', 'lieu']);

        if ($utilisateur->role === 'admin') {
            // Recherche globale admin
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('statut', 'like', "%$search%")
                        ->orWhere('element_type', 'like', "%$search%")
                        ->orWhere('element_id', 'like', "%$search%")
                        ->orWhere('date_debut', 'like', "%$search%")
                        ->orWhere('date_fin', 'like', "%$search%")
                        ->orWhereHas('utilisateur', function ($q2) use ($search) {
                            $q2->where('nom', 'like', "%$search%")
                                ->orWhere('email', 'like', "%$search%");
                        });
                });
            }
        } elseif ($utilisateur->role === 'guide') {
            // Guide : réservations où il est l'élément ou qu'il a faites
            $query->where(function ($q) use ($utilisateur) {
                $q->where('element_type', 'guide')
                    ->where('element_id', $utilisateur->id);
            })
            ->orWhere('utilisateur_id', $utilisateur->id);
        } else {
            // Utilisateur simple
            $query->where('utilisateur_id', $utilisateur->id);
        }

        // Pagination avec 10 éléments par page
        $reservations = $query->latest()->paginate(15);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Affiche uniquement les réservations du guide connecté.
     */
    public function mesReservations()
    {
        $guide = Auth::user();

        // Vérifier que c'est bien un guide
        if ($guide->role !== 'guide') {
            abort(403, 'Accès non autorisé');
        }

        // Récupérer toutes les réservations où ce guide est la cible
        $reservations = Reservation::where('element_type', 'guide')
            ->where('element_id', $guide->id)
            ->with('utilisateur') // Charger l'utilisateur qui a réservé
            ->latest()
            ->get();

        return view('reservations.mes_reservations', compact('reservations'));
    }

    public function create()
    {
        
        $hebergements = Hebergement::where('disponibilite', true)->get();
        $guides = GuideTouristique::where('disponibilite', true)->get();
        $circuits = CircuitTouristique::where('statut', 'actif')->get();
        $lieux = LieuTouristique::all();

        return view('reservations.create', compact('hebergements', 'guides', 'circuits', 'lieux'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'element_type' => 'required|in:hebergement,guide,circuit,lieu',
            'element_id'   => 'required|integer',
            'date_debut'   => 'required|date|after_or_equal:today',
            'date_fin'     => 'required|date|after_or_equal:date_debut',
        ]);

        Reservation::create([
            'utilisateur_id' => Auth::id(),
            'element_type'   => $request->element_type,
            'element_id'     => $request->element_id,
            'date_debut'     => $request->date_debut,
            'date_fin'       => $request->date_fin,
            'statut'         => 'en_attente',
        ]);

        return redirect()->route('reservations.index')->with('success', 'Réservation effectuée avec succès.');
    }

    public function edit($id)
    {
        Gate::authorize('view-admin-section');

        $reservation  = Reservation::findOrFail($id);
        $hebergements = Hebergement::all();
        $guides       = GuideTouristique::all();
        $circuits     = CircuitTouristique::all();
        $lieux        = LieuTouristique::all();
        $utilisateurs = Utilisateur::all();

        return view('reservations.edit', compact('reservation', 'hebergements', 'guides', 'circuits', 'lieux', 'utilisateurs'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('view-admin-section');

        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'element_type'   => 'required|in:hebergement,guide,circuit,lieu',
            'element_id'     => 'required|integer',
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'date_debut'     => 'required|date',
            'date_fin'       => 'required|date|after_or_equal:date_debut',
            'statut'         => 'required|in:en_attente,confirmée,annulée',
        ]);

        $reservation->update($request->all());

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation mise à jour.');
    }

    public function destroy($id)
    {
        Gate::authorize('view-admin-section');

        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('admin.reservations.index')->with('success', 'Réservation supprimée.');
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Seul un administrateur peut changer le statut.');
        }

        $validated = $request->validate([
            'statut' => 'required|in:en_attente,confirmée,annulée',
        ]);

        $reservation         = Reservation::findOrFail($id);
        $reservation->statut = $validated['statut'];
        $reservation->save();

        return redirect()->route('admin.reservations.index')->with('success', 'Statut de la réservation mis à jour.');
    }

    public function annuler($id)
    {
        $reservation = Reservation::findOrFail($id);
        $utilisateur = Auth::user();

        if ($reservation->statut === 'confirmée') {
            return redirect()->back()->with('error', 'Vous ne pouvez pas annuler une réservation confirmée.');
        }

        if ($utilisateur->role !== 'admin' && $reservation->utilisateur_id != $utilisateur->id) {
            abort(403, 'Accès non autorisé.');
        }

        $reservation->statut = 'annulée';
        $reservation->save();

        return redirect()->back()->with('success', 'Réservation annulée avec succès.');
    }

    public function exportExcel()
    {
        return Excel::download(new ReservationsExport, 'reservations.xlsx');
    }

    public function exportPDF()
    {
        $reservations = Reservation::with(['utilisateur', 'hebergement'])->get();
        $pdf          = PDF::loadView('exports.reservations_pdf', compact('reservations'));
        return $pdf->download('reservations.pdf');
    }

    public function mesReservationsGuide()
{
    $utilisateur = Auth::user();

    // Vérifier que c'est bien un guide
    if ($utilisateur->role !== 'guide') {
        abort(403, 'Accès non autorisé');
    }

    // Récupérer les réservations qui concernent CE guide
    $reservations = \App\Models\Reservation::with('utilisateur')
        ->where('element_type', 'guide')
        ->where('element_id', $utilisateur->id)
        ->get();

    return view('reservations.guide', compact('reservations'));
}
}
