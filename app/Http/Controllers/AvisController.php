<?php

namespace App\Http\Controllers;

use App\Models\Avis;
use App\Models\Utilisateur;
use App\Models\Hebergement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AvisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Afficher tous les avis (Admin uniquement)
    public function index()
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $avis = Avis::all();
        return view('avis.index', compact('avis'));
    }

    // Afficher le formulaire pour ajouter un nouvel avis (Admin uniquement)
    public function create()
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $utilisateurs = Utilisateur::all();
        $hebergements = Hebergement::all();
        return view('avis.create', compact('utilisateurs', 'hebergements'));
    }

    // Enregistrer un nouvel avis (Admin uniquement)
    public function store(Request $request)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string',
            'cible_type' => 'required|string|in:Lieu,Hebergement,Guide',
            'cible_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        Avis::create([
            'utilisateur_id' => $request->utilisateur_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'cible_type' => $request->cible_type,
            'cible_id' => $request->cible_id,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.avis.index')->with('success', 'Avis ajouté avec succès');
    }

    // Afficher le formulaire pour modifier un avis (Admin uniquement)
    public function edit($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $avis = Avis::findOrFail($id);
        $utilisateurs = Utilisateur::all();
        $hebergements = Hebergement::all();
        return view('avis.edit', compact('avis', 'utilisateurs', 'hebergements'));
    }

    // Mettre à jour un avis (Admin uniquement)
    public function update(Request $request, $id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $request->validate([
            'utilisateur_id' => 'required|exists:utilisateurs,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'required|string',
            'cible_type' => 'required|string|in:Lieu,Hebergement,Guide',
            'cible_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $avis = Avis::findOrFail($id);
        $avis->update([
            'utilisateur_id' => $request->utilisateur_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
            'cible_type' => $request->cible_type,
            'cible_id' => $request->cible_id,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.avis.index')->with('success', 'Avis mis à jour avec succès');
    }

    // Supprimer un avis (Admin uniquement)
    public function destroy($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $avis = Avis::findOrFail($id);
        $avis->delete();

        return redirect()->route('admin.avis.index')->with('success', 'Avis supprimé avec succès');
    }
}
