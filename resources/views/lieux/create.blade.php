<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un lieu touristique
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Nouveau lieu touristique
                </h2>

                <form action="{{ route('admin.lieux.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom du lieu</label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom') }}"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   required>
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- adresse --}}
                        <div class="col-md-6">
                            <label for="region" class="form-label text-gray-700 dark:text-gray-300">Adresse</label>
                            <input type="text"
                                   id="adresse"
                                   name="adresse"
                                   value="{{ old('adresse') }}"
                                   class="form-control @error('adresse') is-invalid @enderror"
                                   required>
                            @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label for="type" class="form-label text-gray-700 dark:text-gray-300">Type</label>
                            <input type="text"
                                   id="type"
                                   name="type"
                                   value="{{ old('type') }}"
                                   class="form-control @error('type') is-invalid @enderror"
                                   required>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tarif d'entrée --}}
                        <div class="col-md-6">
                            <label for="tarifEntree" class="form-label text-gray-700 dark:text-gray-300">Tarif d’entrée (GNF)</label>
                            <input type="number" step="0.01"
                                   id="tarifEntree"
                                   name="tarifEntree"
                                   value="{{ old('tarifEntree') }}"
                                   class="form-control @error('tarifEntree') is-invalid @enderror"
                                   required>
                            @error('tarifEntree') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Horaires d'ouverture --}}
                        <div class="col-md-6">
                            <label for="horairesOuverture" class="form-label text-gray-700 dark:text-gray-300">Horaires d’ouverture</label>
                            <input type="text"
                                   id="horairesOuverture"
                                   name="horairesOuverture"
                                   value="{{ old('horairesOuverture') }}"
                                   class="form-control @error('horairesOuverture') is-invalid @enderror"
                                   required>
                            @error('horairesOuverture') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Accessibilité --}}
                        <div class="col-md-6">
                            <label for="accessibilite" class="form-label text-gray-700 dark:text-gray-300">Accessibilité</label>
                            <input type="text"
                                   id="accessibilite"
                                   name="accessibilite"
                                   value="{{ old('accessibilite') }}"
                                   class="form-control @error('accessibilite') is-invalid @enderror"
                                   required>
                            @error('accessibilite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Description --}}
                        <div class="col-12">
                            <label for="description" class="form-label text-gray-700 dark:text-gray-300">Description</label>
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="form-control @error('description') is-invalid @enderror"
                                      required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Image principale --}}
                        <div class="col-md-6">
                            <label for="image" class="form-label text-gray-700 dark:text-gray-300">Image principale</label>
                            <input type="file"
                                   id="image"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*"
                                   required>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Galerie d’images --}}
                        <div class="col-md-6">
                            <label for="galerie_images" class="form-label text-gray-700 dark:text-gray-300">Galerie d’images (facultatif)</label>
                            <input type="file"
                                   id="galerie_images"
                                   name="galerie_images[]"
                                   class="form-control @error('galerie_images') is-invalid @enderror"
                                   accept="image/*"
                                   multiple>
                            @error('galerie_images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                       <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Ajouter le lieu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
