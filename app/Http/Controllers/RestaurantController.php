<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

        public function index(Request $request)
    {
        $query = Restaurant::query();

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%')
                ->orWhere('specialites', 'like', '%' . $request->search . '%')
                ->orWhere('adresse', 'like', '%' . $request->search . '%');
        }

        // Pagination avec 10 éléments par page
        $restaurants = $query->latest()->paginate(8);

        foreach ($restaurants as $restaurant) {
            $restaurant->galerie_images_restaurant = is_string($restaurant->galerie_images_restaurant)
                ? json_decode($restaurant->galerie_images_restaurant, true)
                : [];
        }

        return view('restaurants.index', compact('restaurants'));
    }


    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $restaurant->galerie_images_restaurant = is_string($restaurant->galerie_images_restaurant)
            ? json_decode($restaurant->galerie_images_restaurant, true)
            : [];

        return view('restaurants.show', compact('restaurant'));
    }

    public function create()
    {
        Gate::authorize('view-admin-section');
        return view('restaurants.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'specialites' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tarifMoyen' => 'required|numeric',
            'contact' => 'required|string|max:255',
            'noteMoyenne' => 'nullable|numeric|min:0|max:5',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'galerie_images_restaurant.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $validated['image_url'] = $request->file('image_url')->store('restaurants_images', 'public');

        $restaurant = Restaurant::create($validated);

        if ($request->hasFile('galerie_images_restaurant')) {
            $galerie = [];
            foreach ($request->file('galerie_images_restaurant') as $image) {
                $galerie[] = $image->store('galerie_restaurants', 'public');
            }
            $restaurant->galerie_images_restaurant = json_encode($galerie);
            $restaurant->save();
        }

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant ajouté avec succès.');
    }

    public function edit($id)
    {
        Gate::authorize('view-admin-section');

        $restaurant = Restaurant::findOrFail($id);
        $galerie = is_string($restaurant->galerie_images_restaurant)
            ? json_decode($restaurant->galerie_images_restaurant, true)
            : [];

        return view('restaurants.edit', compact('restaurant', 'galerie'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('view-admin-section');

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'specialites' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'tarifMoyen' => 'required|numeric',
            'contact' => 'required|string|max:255',
            'noteMoyenne' => 'nullable|numeric|min:0|max:5',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'galerie_images_restaurant.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $restaurant = Restaurant::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($restaurant->image_url && Storage::disk('public')->exists($restaurant->image_url)) {
                Storage::disk('public')->delete($restaurant->image_url);
            }
            $validated['image_url'] = $request->file('image_url')->store('restaurants_images', 'public');
        } else {
            $validated['image_url'] = $restaurant->image_url;
        }

        $restaurant->update($validated);

        if ($request->hasFile('galerie_images_restaurant')) {
            $ancienneGalerie = is_string($restaurant->galerie_images_restaurant)
                ? json_decode($restaurant->galerie_images_restaurant, true)
                : [];

            foreach ($ancienneGalerie as $oldImage) {
                if (is_string($oldImage) && Storage::disk('public')->exists($oldImage)) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $galerie = [];
            foreach ($request->file('galerie_images_restaurant') as $image) {
                $galerie[] = $image->store('galerie_restaurants', 'public');
            }

            $restaurant->galerie_images_restaurant = json_encode($galerie);
            $restaurant->save();
        }

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant mis à jour avec succès.');
    }

    public function destroy(Restaurant $restaurant)
    {
        Gate::authorize('view-admin-section');

        if ($restaurant->image_url && Storage::disk('public')->exists($restaurant->image_url)) {
            Storage::disk('public')->delete($restaurant->image_url);
        }

        $galerie = is_string($restaurant->galerie_images_restaurant)
            ? json_decode($restaurant->galerie_images_restaurant, true)
            : [];

        foreach ($galerie as $img) {
            if (is_string($img) && Storage::disk('public')->exists($img)) {
                Storage::disk('public')->delete($img);
            }
        }

        $restaurant->delete();

        return redirect()->route('admin.restaurants.index')->with('success', 'Restaurant supprimé avec succès.');
    }
}
