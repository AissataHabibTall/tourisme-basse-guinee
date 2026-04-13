<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

        public function index(Request $request)
    {
        $query = Event::query();

        // Recherche par titre, date_debut ou date_fin
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('titre', 'like', '%' . $search . '%')
                ->orWhereDate('date_debut', $search)
                ->orWhereDate('date_fin', $search);
        }

         // Pagination avec 10 éléments par page
        $events = $query->latest()->paginate(8);

        // Décode la galerie si elle est une chaîne
        foreach ($events as $event) {
            $event->galerie_images_event = is_string($event->galerie_images_event)
                ? json_decode($event->galerie_images_event, true)
                : [];
        }

        return view('events.index', compact('events'));
    }

    public function show(Event $event)
    {
        $event->galerie_images_event = is_string($event->galerie_images_event)
            ? json_decode($event->galerie_images_event, true)
            : [];

        return view('events.show', compact('event'));
    }

    public function create()
    {
        Gate::authorize('view-admin-section');

        return view('events.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galerie_images_event.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['image'] = $request->file('image')->store('events_images', 'public');

        $galerie = [];
        if ($request->hasFile('galerie_images_event')) {
            foreach ($request->file('galerie_images_event') as $image) {
                $galerie[] = $image->store('events_galerie', 'public');
            }
        }

        $validated['galerie_images_event'] = json_encode($galerie);

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Événement ajouté avec succès.');
    }

    public function edit(Event $event)
    {
        Gate::authorize('view-admin-section');

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'galerie_images_event.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Image principale
        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            $validated['image'] = $request->file('image')->store('events_images', 'public');
        } else {
            $validated['image'] = $event->image;
        }

        // Galerie d'images
        if ($request->hasFile('galerie_images_event')) {
            $ancienneGalerie = is_string($event->galerie_images_event)
                ? json_decode($event->galerie_images_event, true)
                : [];

            foreach ($ancienneGalerie as $img) {
                if (Storage::disk('public')->exists($img)) {
                    Storage::disk('public')->delete($img);
                }
            }

            $nouvelleGalerie = [];
            foreach ($request->file('galerie_images_event') as $image) {
                $nouvelleGalerie[] = $image->store('events_galerie', 'public');
            }

            $validated['galerie_images_event'] = json_encode($nouvelleGalerie);
        } else {
            $validated['galerie_images_event'] = $event->galerie_images_event;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Événement modifié avec succès.');
    }

    public function destroy(Event $event)
    {
        Gate::authorize('view-admin-section');

        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $galerie = is_string($event->galerie_images_event)
            ? json_decode($event->galerie_images_event, true)
            : [];

        foreach ($galerie as $img) {
            if (Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Événement supprimé avec succès.');
    }
}
