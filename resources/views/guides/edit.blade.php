<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier le guide touristique
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Modifier le guide : {{ $guide->nom }}
                </h2>

                <form action="{{ route('admin.guides.update', $guide->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom', $guide->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   required>
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Langues parlées --}}
                        <div class="col-md-6">
                            <label for="languesParlees" class="form-label text-gray-700 dark:text-gray-300">Langues parlées</label>
                            <input type="text"
                                   id="languesParlees"
                                   name="languesParlees"
                                   value="{{ old('languesParlees', $guide->languesParlees) }}"
                                   class="form-control @error('languesParlees') is-invalid @enderror"
                                   required>
                            @error('languesParlees') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Zone couverte --}}
                        <div class="col-md-6">
                            <label for="zoneCouverte" class="form-label text-gray-700 dark:text-gray-300">Zone couverte</label>
                            <input type="text"
                                   id="zoneCouverte"
                                   name="zoneCouverte"
                                   value="{{ old('zoneCouverte', $guide->zoneCouverte) }}"
                                   class="form-control @error('zoneCouverte') is-invalid @enderror"
                                   required>
                            @error('zoneCouverte') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Expérience --}}
                        <div class="col-12">
                            <label for="experience" class="form-label text-gray-700 dark:text-gray-300">Expérience</label>
                            <textarea id="experience"
                                      name="experience"
                                      rows="4"
                                      class="form-control @error('experience') is-invalid @enderror"
                                      required>{{ old('experience', $guide->experience) }}</textarea>
                            @error('experience') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tarif journalier --}}
                        <div class="col-md-6">
                            <label for="tarifJournalier" class="form-label text-gray-700 dark:text-gray-300">Tarif journalier (GNF)</label>
                            <input type="number" step="0.01"
                                   id="tarifJournalier"
                                   name="tarifJournalier"
                                   value="{{ old('tarifJournalier', $guide->tarifJournalier) }}"
                                   class="form-control @error('tarifJournalier') is-invalid @enderror"
                                   required>
                            @error('tarifJournalier') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Contact --}}
                        <div class="col-md-6">
                            <label for="contact" class="form-label text-gray-700 dark:text-gray-300">Contact</label>
                            <input type="text"
                                   id="contact"
                                   name="contact"
                                   value="{{ old('contact', $guide->contact) }}"
                                   class="form-control @error('contact') is-invalid @enderror"
                                   required>
                            @error('contact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Disponibilité --}}
                        <div class="col-md-6">
                            <label for="disponibilite" class="form-label text-gray-700 dark:text-gray-300">Disponibilité</label>
                            <select id="disponibilite"
                                    name="disponibilite"
                                    class="form-select @error('disponibilite') is-invalid @enderror"
                                    required>
                                <option value="">-- Sélectionner --</option>
                                <option value="1" {{ old('disponibilite', $guide->disponibilite) == '1' ? 'selected' : '' }}>Disponible</option>
                                <option value="0" {{ old('disponibilite', $guide->disponibilite) == '0' ? 'selected' : '' }}>Indisponible</option>
                            </select>
                            @error('disponibilite') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Image actuelle --}}
                        @if ($guide->image)
                            <div class="col-md-6">
                                <label class="form-label text-gray-700 dark:text-gray-300">Image actuelle</label>
                                <div>
                                    <img src="{{ asset('storage/' . $guide->image) }}" alt="Image actuelle" class="rounded-md max-w-xs mt-1">
                                </div>
                            </div>
                        @endif

                        {{-- Nouvelle image --}}
                        <div class="col-md-6">
                            <label for="image" class="form-label text-gray-700 dark:text-gray-300">Changer l'image (laisser vide pour conserver)</label>
                            <input type="file"
                                   id="image"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror"
                                   accept="image/*">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Mettre à jour le guide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
