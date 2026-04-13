<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier un hébergement
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-6 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-6 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Modifier l’hébergement : {{ $hebergement->nom }}
                </h2>

                <form action="{{ route('admin.hebergements.update', $hebergement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom', $hebergement->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   required>
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label for="type" class="form-label text-gray-700 dark:text-gray-300">Type</label>
                            <input type="text"
                                   id="type"
                                   name="type"
                                   value="{{ old('type', $hebergement->type) }}"
                                   class="form-control @error('type') is-invalid @enderror"
                                   required>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Adresse --}}
                        <div class="col-md-6">
                            <label for="adresse" class="form-label text-gray-700 dark:text-gray-300">Adresse</label>
                            <input type="text"
                                   id="adresse"
                                   name="adresse"
                                   value="{{ old('adresse', $hebergement->adresse) }}"
                                   class="form-control @error('adresse') is-invalid @enderror"
                                   required>
                            @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Prix par nuit --}}
                        <div class="col-md-6">
                            <label for="prixParNuit" class="form-label text-gray-700 dark:text-gray-300">Prix par nuit</label>
                            <input type="number" step="0.01"
                                   id="prixParNuit"
                                   name="prixParNuit"
                                   value="{{ old('prixParNuit', $hebergement->prixParNuit) }}"
                                   class="form-control @error('prixParNuit') is-invalid @enderror"
                                   required>
                            @error('prixParNuit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Disponibilité --}}
                        <div class="col-md-6">
                            <label for="disponibilite" class="form-label text-gray-700 dark:text-gray-300">Disponibilité</label>
                            <select id="disponibilite"
                                    name="disponibilite"
                                    class="form-select @error('disponibilite') is-invalid @enderror"
                                    required>
                                <option value="1" {{ old('disponibilite', $hebergement->disponibilite) == 1 ? 'selected' : '' }}>Disponible</option>
                                <option value="0" {{ old('disponibilite', $hebergement->disponibilite) == 0 ? 'selected' : '' }}>Indisponible</option>
                            </select>
                            @error('disponibilite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Contact --}}
                        <div class="col-md-6">
                            <label for="contact" class="form-label text-gray-700 dark:text-gray-300">Contact</label>
                            <input type="text"
                                   id="contact"
                                   name="contact"
                                   value="{{ old('contact', $hebergement->contact) }}"
                                   class="form-control @error('contact') is-invalid @enderror"
                                   required>
                            @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Note moyenne --}}
                        <!--<div class="col-md-6">
                            <label for="noteMoyenne" class="form-label text-gray-700 dark:text-gray-300">Note moyenne (facultatif)</label>
                            <input type="number" step="0.01" min="0" max="5"
                                   id="noteMoyenne"
                                   name="noteMoyenne"
                                   value="{{ old('noteMoyenne', $hebergement->noteMoyenne) }}"
                                   class="form-control @error('noteMoyenne') is-invalid @enderror">
                            @error('noteMoyenne') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div> -->

                        {{-- Image principale --}}
                        <div class="col-md-6">
                            <label for="image_url" class="form-label text-gray-700 dark:text-gray-300">
                                Changer l’image principale (laisser vide pour conserver)
                            </label>

                            @if($hebergement->image_url)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $hebergement->image_url) }}" alt="Image actuelle" class="rounded max-w-xs">
                                </div>
                            @endif

                            <input type="file"
                                   id="image_url"
                                   name="image_url"
                                   class="form-control @error('image_url') is-invalid @enderror"
                                   accept="image/*">
                            @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Galerie d’images --}}
                        <div class="col-md-6">
                            <label for="galerie_images_hebergement" class="form-label text-gray-700 dark:text-gray-300">
                                Ajouter des images à la galerie (facultatif)
                            </label>
                            <input type="file"
                                   id="galerie_images_hebergement"
                                   name="galerie_images_hebergement[]"
                                   class="form-control @error('galerie_images_hebergement') is-invalid @enderror"
                                   accept="image/*"
                                   multiple>
                            @error('galerie_images_hebergement') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @error('galerie_images_hebergement.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Galerie existante --}}
                        @if(is_array($hebergement->galerie_images_hebergement) && count($hebergement->galerie_images_hebergement) > 0)
                            <div class="col-12 mt-4">
                                <h4 class="text-gray-700 dark:text-gray-300 font-semibold mb-2">Images existantes :</h4>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($hebergement->galerie_images_hebergement as $image)
                                        @if(is_string($image))
                                            <img src="{{ asset('storage/' . $image) }}"
                                                 alt="Galerie"
                                                 class="h-20 rounded object-cover">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 text-center">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Mettre à jour l'hébergement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
