<?php

namespace App\Http\Controllers;

use App\Models\GuideTouristique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class GuideTouristiqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

        public function index(Request $request)
    {
        $query = GuideTouristique::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', '%' . $search . '%')
                ->orWhere('languesParlees', 'like', '%' . $search . '%');
        }

        // Pagination avec 10 éléments par page
        $guides = $query->latest()->paginate(8);

        return view('guides.index', compact('guides'));
    }

    public function create()
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        return view('guides.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'languesParlees' => 'required|string|max:255',
            'zoneCouverte' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'tarifJournalier' => 'required|numeric',
            'contact' => 'required|string|max:255',
            'disponibilite' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/guides', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        GuideTouristique::create([
            'nom' => $request->nom,
            'languesParlees' => $request->languesParlees,
            'zoneCouverte' => $request->zoneCouverte,
            'experience' => $request->experience,
            'tarifJournalier' => $request->tarifJournalier,
            'contact' => $request->contact,
            'disponibilite' => $request->disponibilite,
            'image_url' => $imageUrl,
        ]);

        return redirect()->route('guides.index')->with('success', 'Guide ajouté avec succès!');
    }

    public function edit($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $guide = GuideTouristique::findOrFail($id);
        return view('guides.edit', compact('guide'));
    }

    public function update(Request $request, $id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $request->validate([
            'nom' => 'required|string|max:255',
            'languesParlees' => 'required|string|max:255',
            'zoneCouverte' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'tarifJournalier' => 'required|numeric',
            'contact' => 'required|string|max:255',
            'disponibilite' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $guide = GuideTouristique::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($guide->image_url) {
                $imagePath = str_replace(asset('storage/'), 'public/', $guide->image_url);
                Storage::delete($imagePath);
            }

            $imagePath = $request->file('image')->store('images/guides', 'public');
            $guide->image_url = asset('storage/' . $imagePath);
        }

        $guide->update([
            'nom' => $request->nom,
            'languesParlees' => $request->languesParlees,
            'zoneCouverte' => $request->zoneCouverte,
            'experience' => $request->experience,
            'tarifJournalier' => $request->tarifJournalier,
            'contact' => $request->contact,
            'disponibilite' => $request->disponibilite,
        ]);

        return redirect()->route('guides.index')->with('success', 'Guide mis à jour avec succès!');
    }

    public function destroy($id)
    {
        if (Gate::denies('view-admin-section')) {
            abort(403, 'Accès interdit.');
        }

        $guide = GuideTouristique::findOrFail($id);

        if ($guide->image_url) {
            $imagePath = str_replace(asset('storage/'), 'public/', $guide->image_url);
            Storage::delete($imagePath);
        }

        $guide->delete();

        return redirect()->route('guides.index')->with('success', 'Guide supprimé avec succès!');
    }

    public function show($id)
    {
        $guide = GuideTouristique::findOrFail($id);
        return view('guides.show', compact('guide'));
    }
}
