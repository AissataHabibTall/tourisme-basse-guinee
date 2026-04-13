<?php

namespace App\Http\Controllers;

use App\Models\LieuTouristique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class LieuTouristiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    // Liste tous les lieux
        public function index(Request $request)
    {
        $query = LieuTouristique::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('adresse', 'like', '%' . $search . '%');
        }

        // Pagination avec 10 éléments par page
        $lieux = $query->latest()->paginate(8);

        // Décode la galerie si nécessaire
        foreach ($lieux as $lieu) {
            $lieu->galerie_images = is_string($lieu->galerie_images)
                ? json_decode($lieu->galerie_images, true)
                : [];
        }

        

        return view('lieux.index', compact('lieux'));
    }


    // Affiche un lieu en détail
    public function show($id)
    {
        $lieu = LieuTouristique::findOrFail($id);

        return view('lieux.show', compact('lieu'));
    }

    // Formulaire de création
    public function create()
    {
        Gate::authorize('view-admin-section');

        return view('lieux.create');
    }

    // Enregistrement d’un nouveau lieu
    public function store(Request $request)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'adresse' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            //'coordonneesGPS' => 'nullable|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galerie_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tarifEntree' => 'nullable|numeric',
            'horairesOuverture' => 'nullable|string|max:255',
            'accessibilite' => 'nullable|string|max:255',
        ]);

        // Enregistrement image principale
        $validated['image'] = $request->file('image')->store('lieux_images', 'public');

        // Galerie d’images
        $galerie = [];
        if ($request->hasFile('galerie_images')) {
            foreach ($request->file('galerie_images') as $image) {
                $galerie[] = $image->store('galerie_lieux', 'public');
            }
        }

        $validated['galerie_images'] = $galerie;

        LieuTouristique::create($validated);

        return redirect()->route('admin.lieux.index')->with('success', 'Lieu ajouté avec succès.');
    }

    // Formulaire de modification
    public function edit($id)
    {
        Gate::authorize('view-admin-section');

        $lieu = LieuTouristique::findOrFail($id);

        return view('lieux.edit', compact('lieu'));
    }

    // Mise à jour d’un lieu
    public function update(Request $request, $id)
    {
        Gate::authorize('view-admin-section');

        $lieu = LieuTouristique::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'adresse' => 'nullable|string|max:100',
            'type' => 'nullable|string|max:100',
            //'coordonneesGPS' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galerie_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tarifEntree' => 'nullable|numeric',
            'horairesOuverture' => 'nullable|string|max:255',
            'accessibilite' => 'nullable|string|max:255',
        ]);

        // Image principale
        if ($request->hasFile('image')) {
            if ($lieu->image && Storage::disk('public')->exists($lieu->image)) {
                Storage::disk('public')->delete($lieu->image);
            }
            $validated['image'] = $request->file('image')->store('lieux_images', 'public');
        } else {
            $validated['image'] = $lieu->image;
        }

        // Mise à jour galerie
        if ($request->hasFile('galerie_images')) {
            // Supprimer anciennes images
            if (is_array($lieu->galerie_images)) {
                foreach ($lieu->galerie_images as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            $galerie = [];
            foreach ($request->file('galerie_images') as $image) {
                $galerie[] = $image->store('galerie_lieux', 'public');
            }

            $validated['galerie_images'] = $galerie;
        } else {
            $validated['galerie_images'] = $lieu->galerie_images;
        }

        $lieu->update($validated);

        return redirect()->route('admin.lieux.index')->with('success', 'Lieu mis à jour avec succès.');
    }

    // Suppression d’un lieu
    public function destroy($id)
    {
        Gate::authorize('view-admin-section');

        $lieu = LieuTouristique::findOrFail($id);

        if ($lieu->image && Storage::disk('public')->exists($lieu->image)) {
            Storage::disk('public')->delete($lieu->image);
        }

        if (is_array($lieu->galerie_images)) {
            foreach ($lieu->galerie_images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $lieu->delete();

        return redirect()->route('admin.lieux.index')->with('success', 'Lieu supprimé avec succès.');
    }
}
