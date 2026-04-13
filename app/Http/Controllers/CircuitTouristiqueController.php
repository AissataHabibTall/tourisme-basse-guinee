<?php

namespace App\Http\Controllers;

use App\Models\CircuitTouristique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CircuitTouristiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Affiche la liste des circuits (admin uniquement)
    public function index()
    {
        //if (Gate::denies('view-admin-section')) {
            //abort(403, 'Accès interdit.');
        //}

        $circuits = CircuitTouristique::all();
        return view('circuits.index', compact('circuits'));
    }

    // Affiche le formulaire de création
    public function create()
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        return view('circuits.create');
    }

    // Enregistre un nouveau circuit
    public function store(Request $request)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'statut' => 'required|in:actif,inactif',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Enregistre l'image
        $validated['image'] = $request->file('image')->store('circuits_images', 'public');

        CircuitTouristique::create($validated);

        return redirect()->route('admin.circuits.index')->with('success', 'Circuit touristique ajouté avec succès.');
    }

    // Affiche le formulaire d’édition
    public function edit($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $circuit = CircuitTouristique::findOrFail($id);
        return view('circuits.edit', compact('circuit'));
    }

    // Met à jour un circuit existant
    public function update(Request $request, $id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date|after_or_equal:dateDebut',
            'statut' => 'required|in:actif,inactif',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $circuit = CircuitTouristique::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($circuit->image && Storage::disk('public')->exists($circuit->image)) {
                Storage::disk('public')->delete($circuit->image);
            }
            $validated['image'] = $request->file('image')->store('circuits_images', 'public');
        } else {
            $validated['image'] = $circuit->image;
        }

        $circuit->update($validated);

        return redirect()->route('admin.circuits.index')->with('success', 'Circuit mis à jour avec succès.');
    }

    // Supprime un circuit
    public function destroy($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $circuit = CircuitTouristique::findOrFail($id);

        if ($circuit->image && Storage::disk('public')->exists($circuit->image)) {
            Storage::disk('public')->delete($circuit->image);
        }

        $circuit->delete();

        return redirect()->route('admin.circuits.index')->with('success', 'Circuit supprimé avec succès.');
    }
}
