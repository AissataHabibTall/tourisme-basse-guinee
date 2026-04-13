<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier le restaurant
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Modifier le restaurant : {{ $restaurant->nom }}
                </h2>

                @if(Auth::user()->role !== 'admin')
                    <div class="text-red-600 font-bold text-center mb-4">Accès non autorisé.</div>
                @else
                    <form action="{{ route('admin.restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            {{-- Nom --}}
                            <div class="col-md-6">
                                <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom</label>
                                <input type="text"
                                       id="nom"
                                       name="nom"
                                       value="{{ old('nom', $restaurant->nom) }}"
                                       class="form-control @error('nom') is-invalid @enderror"
                                       required>
                                @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Spécialités --}}
                            <div class="col-md-6">
                                <label for="specialites" class="form-label text-gray-700 dark:text-gray-300">Spécialités</label>
                                <input type="text"
                                       id="specialites"
                                       name="specialites"
                                       value="{{ old('specialites', $restaurant->specialites) }}"
                                       class="form-control @error('specialites') is-invalid @enderror"
                                       required>
                                @error('specialites') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Adresse --}}
                            <div class="col-md-6">
                                <label for="adresse" class="form-label text-gray-700 dark:text-gray-300">Adresse</label>
                                <input type="text"
                                       id="adresse"
                                       name="adresse"
                                       value="{{ old('adresse', $restaurant->adresse) }}"
                                       class="form-control @error('adresse') is-invalid @enderror"
                                       required>
                                @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tarif moyen --}}
                            <div class="col-md-6">
                                <label for="tarifMoyen" class="form-label text-gray-700 dark:text-gray-300">Tarif moyen (GNF)</label>
                                <input type="number" step="0.01"
                                       id="tarifMoyen"
                                       name="tarifMoyen"
                                       value="{{ old('tarifMoyen', $restaurant->tarifMoyen) }}"
                                       class="form-control @error('tarifMoyen') is-invalid @enderror"
                                       required>
                                @error('tarifMoyen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Contact --}}
                            <div class="col-md-6">
                                <label for="contact" class="form-label text-gray-700 dark:text-gray-300">Contact</label>
                                <input type="text"
                                       id="contact"
                                       name="contact"
                                       value="{{ old('contact', $restaurant->contact) }}"
                                       class="form-control @error('contact') is-invalid @enderror"
                                       required>
                                @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Note moyenne --}}
                            <!--<div class="col-md-6">
                                <label for="noteMoyenne" class="form-label text-gray-700 dark:text-gray-300">Note moyenne (0 à 5)</label>
                                <input type="number" step="0.1" min="0" max="5"
                                       id="noteMoyenne"
                                       name="noteMoyenne"
                                       value="{{ old('noteMoyenne', $restaurant->noteMoyenne) }}"
                                       class="form-control @error('noteMoyenne') is-invalid @enderror"
                                       required>
                                @error('noteMoyenne') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div> -->

                            {{-- Image principale --}}
                            <div class="col-md-6">
                                <label for="image_url" class="form-label text-gray-700 dark:text-gray-300">Image principale (laisser vide pour conserver)</label>
                                <input type="file"
                                       id="image_url"
                                       name="image_url"
                                       class="form-control @error('image_url') is-invalid @enderror"
                                       accept="image/*">
                                @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                @if($restaurant->image_url)
                                    <img src="{{ asset('storage/' . $restaurant->image_url) }}" alt="Image du restaurant" class="mt-2 rounded-md max-w-xs">
                                @endif
                            </div>

                            {{-- Galerie d’images --}}
                            <div class="col-md-6">
                                <label for="galerie_images_restaurant" class="form-label text-gray-700 dark:text-gray-300">Ajouter des images à la galerie (facultatif)</label>
                                <input type="file"
                                       id="galerie_images_restaurant"
                                       name="galerie_images_restaurant[]"
                                       class="form-control @error('galerie_images_restaurant') is-invalid @enderror"
                                       accept="image/*"
                                       multiple>
                                @error('galerie_images_restaurant') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Galerie existante --}}
                        @if(is_array($restaurant->galerie_images_restaurant) && count($restaurant->galerie_images_restaurant) > 0)
                            <div class="mt-4">
                                <h4 class="text-gray-700 dark:text-gray-300 font-semibold mb-2">Images existantes :</h4>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($restaurant->galerie_images_restaurant as $image)
                                        @if(is_string($image))
                                            <img src="{{ asset('storage/' . $image) }}"
                                                 alt="Galerie"
                                                 class="h-16 w-24 object-cover rounded">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mt-4 text-center">
                            <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Mettre à jour le restaurant
                        </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
