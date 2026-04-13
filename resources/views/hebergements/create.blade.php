<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un hébergement
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Nouvel hébergement
                </h2>

                <form action="{{ route('admin.hebergements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom') }}"
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
                                   value="{{ old('type') }}"
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
                                   value="{{ old('adresse') }}"
                                   class="form-control @error('adresse') is-invalid @enderror"
                                   required>
                            @error('adresse') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Prix par nuit --}}
                        <div class="col-md-6">
                            <label for="prixParNuit" class="form-label text-gray-700 dark:text-gray-300">Prix par nuit (GNF)</label>
                            <input type="number" step="0.01"
                                   id="prixParNuit"
                                   name="prixParNuit"
                                   value="{{ old('prixParNuit') }}"
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
                                <option value="">-- Sélectionner --</option>
                                <option value="1" {{ old('disponibilite') == '1' ? 'selected' : '' }}>Disponible</option>
                                <option value="0" {{ old('disponibilite') == '0' ? 'selected' : '' }}>Indisponible</option>
                            </select>
                            @error('disponibilite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Contact --}}
                        <div class="col-md-6">
                            <label for="contact" class="form-label text-gray-700 dark:text-gray-300">Contact</label>
                            <input type="text"
                                   id="contact"
                                   name="contact"
                                   value="{{ old('contact') }}"
                                   class="form-control @error('contact') is-invalid @enderror"
                                   required>
                            @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Note moyenne --}}
                        <!--<div class="col-md-6">
                            <label for="noteMoyenne" class="form-label text-gray-700 dark:text-gray-300">Note moyenne (optionnelle)</label>
                            <input type="number" step="0.1" min="0" max="5"
                                   id="noteMoyenne"
                                   name="noteMoyenne"
                                   value="{{ old('noteMoyenne') }}"
                                   class="form-control @error('noteMoyenne') is-invalid @enderror">
                            @error('noteMoyenne') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>-->

                        {{-- Image principale --}}
                        <div class="col-md-6">
                            <label for="image_url" class="form-label text-gray-700 dark:text-gray-300">Image principale</label>
                            <input type="file"
                                   id="image_url"
                                   name="image_url"
                                   accept="image/*"
                                   class="form-control @error('image_url') is-invalid @enderror"
                                   required>
                            @error('image_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Galerie d'images --}}
                        <div class="col-md-6">
                            <label for="galerie_images" class="form-label text-gray-700 dark:text-gray-300">Galerie d'images (facultatif)</label>
                            <input type="file"
                                   id="galerie_images"
                                   name="galerie_images[]"
                                   accept="image/*"
                                   multiple
                                   class="form-control @error('galerie_images') is-invalid @enderror">
                            @error('galerie_images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @error('galerie_images.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                <div class="mt-4 text-center">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Ajouter l'hébergement
                    </button>
                </div>
                
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
