<?php

namespace App\Http\Controllers;

use App\Models\Hebergement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class HebergementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request)
{
    $query = Hebergement::query();
// 🔍 Recherche globale
if ($request->filled('search')) {
    $search = strtolower($request->search); // minuscule pour comparer facilement

    $query->where(function ($q) use ($search) {
        $q->where('nom', 'like', "%$search%")
          ->orWhere('type', 'like', "%$search%")
          ->orWhere('adresse', 'like', "%$search%")
          ->orwhere('disponibilite', 'like', "%$search%");

        // Recherche sur la disponibilité
        if (str_contains($search, 'disponible')) {
            $q->orWhere('disponibilite', true);
        } elseif (str_contains($search, 'indisponible')) {
            $q->orWhere('disponibilite', false);
        }
    });
}


    // Pagination avec 10 éléments par page
        $hebergements = $query->latest()->paginate(8);

    
        foreach ($hebergements as $item) {
            $item->galerie_images_hebergement = is_string($item->galerie_images_hebergement)
                ? json_decode($item->galerie_images_hebergement, true)
                : [];
        }

    return view('hebergements.index', compact('hebergements'));
}

    public function show($id)
    {
        $hebergement = Hebergement::findOrFail($id);

        $hebergement->galerie_images_hebergement = is_string($hebergement->galerie_images_hebergement)
            ? json_decode($hebergement->galerie_images_hebergement, true)
            : [];

        return view('hebergements.show', compact('hebergement'));
    }

    public function create()
    {
        Gate::authorize('view-admin-section');
        return view('hebergements.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'prixParNuit' => 'required|numeric',
            'disponibilite' => 'required|boolean',
            'contact' => 'required|string|max:255',
            //'noteMoyenne' => 'nullable|numeric|min:0|max:5',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'galerie_images_hebergement.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Image principale
        $validated['image_url'] = $request->file('image_url')
            ? $request->file('image_url')->store('hebergements_images', 'public')
            : null;

        // Crée l'hébergement
        $hebergement = Hebergement::create($validated);

        // Galerie d'images
        if ($request->hasFile('galerie_images_hebergement')) {
            $galerie = [];
            foreach ($request->file('galerie_images_hebergement') as $img) {
                $galerie[] = $img->store('galerie_hebergements', 'public');
            }

            $hebergement->galerie_images_hebergement = json_encode($galerie);
            $hebergement->save();
        }

        return redirect()->route('admin.hebergements.index')->with('success', 'Hébergement ajouté avec succès.');
    }

    public function edit($id)
    {
        Gate::authorize('view-admin-section');

        $hebergement = Hebergement::findOrFail($id);
        $galerie = is_string($hebergement->galerie_images_hebergement)
            ? json_decode($hebergement->galerie_images_hebergement, true)
            : [];

        return view('hebergements.edit', compact('hebergement', 'galerie'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'prixParNuit' => 'required|numeric',
            'disponibilite' => 'required|boolean',
            'contact' => 'required|string|max:255',
            //'noteMoyenne' => 'nullable|numeric|min:0|max:5',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'galerie_images_hebergement.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $hebergement = Hebergement::findOrFail($id);

        // Image principale
        if ($request->hasFile('image_url')) {
            if ($hebergement->image_url && Storage::disk('public')->exists($hebergement->image_url)) {
                Storage::disk('public')->delete($hebergement->image_url);
            }

            $validated['image_url'] = $request->file('image_url')->store('hebergements_images', 'public');
        } else {
            $validated['image_url'] = $hebergement->image_url;
        }

        $hebergement->update($validated);

        // Galerie
        if ($request->hasFile('galerie_images_hebergement')) {
            $ancienneGalerie = is_string($hebergement->galerie_images_hebergement)
                ? json_decode($hebergement->galerie_images_hebergement, true)
                : [];

            foreach ($ancienneGalerie as $oldImage) {
                if (is_string($oldImage) && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $galerie = [];
            foreach ($request->file('galerie_images_hebergement') as $img) {
                $galerie[] = $img->store('galerie_hebergements', 'public');
            }

            $hebergement->galerie_images_hebergement = json_encode($galerie);
            $hebergement->save();
        }

        return redirect()->route('admin.hebergements.index')->with('success', 'Hébergement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        Gate::authorize('view-admin-section');

        $hebergement = Hebergement::findOrFail($id);

        // Supprime l'image principale
        if ($hebergement->image_url && Storage::disk('public')->exists($hebergement->image_url)) {
            Storage::disk('public')->delete($hebergement->image_url);
        }

        // Supprime les images de la galerie
        $galerie = is_string($hebergement->galerie_images_hebergement)
            ? json_decode($hebergement->galerie_images_hebergement, true)
            : [];

        foreach ($galerie as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        $hebergement->delete();

        return redirect()->route('admin.hebergements.index')->with('success', 'Hébergement supprimé avec succès.');
    }
}
