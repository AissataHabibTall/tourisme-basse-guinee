<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier un événement
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Modifier un événement
                </h2>

                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="titre" class="form-label text-gray-700 dark:text-gray-300">Titre</label>
                            <input type="text" id="titre" name="titre"
                                   value="{{ old('titre', $event->titre) }}"
                                   class="form-control @error('titre') is-invalid @enderror" required>
                            @error('titre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="lieu" class="form-label text-gray-700 dark:text-gray-300">Lieu</label>
                            <input type="text" id="lieu" name="lieu"
                                   value="{{ old('lieu', $event->lieu) }}"
                                   class="form-control @error('lieu') is-invalid @enderror" required>
                            @error('lieu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label text-gray-700 dark:text-gray-300">Description</label>
                            <textarea id="description" name="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $event->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_debut" class="form-label text-gray-700 dark:text-gray-300">Date de début</label>
                            <input type="date" id="date_debut" name="date_debut"
                                   value="{{ old('date_debut', $event->date_debut) }}"
                                   class="form-control @error('date_debut') is-invalid @enderror" required>
                            @error('date_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="date_fin" class="form-label text-gray-700 dark:text-gray-300">Date de fin</label>
                            <input type="date" id="date_fin" name="date_fin"
                                   value="{{ old('date_fin', $event->date_fin) }}"
                                   class="form-control @error('date_fin') is-invalid @enderror" required>
                            @error('date_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prix" class="form-label text-gray-700 dark:text-gray-300">Prix (GNF)</label>
                            <input type="number" id="prix" name="prix"
                                   value="{{ old('prix', $event->prix) }}"
                                   class="form-control @error('prix') is-invalid @enderror" required>
                            @error('prix') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="image" class="form-label text-gray-700 dark:text-gray-300">Image principale</label>
                            <input type="file" id="image" name="image"
                                   class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            @if($event->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="Image actuelle" class="w-32 h-24 object-cover rounded shadow">
                                </div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <label for="galerie_images_event" class="form-label text-gray-700 dark:text-gray-300">Galerie d’images</label>
                            <input type="file" id="galerie_images_event" name="galerie_images_event[]" multiple
                                   class="form-control @error('galerie_images_event') is-invalid @enderror" accept="image/*">
                            @error('galerie_images_event') <div class="invalid-feedback">{{ $message }}</div> @enderror

                            @if ($event->galerie_images_event)
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @foreach (explode(',', $event->galerie_images_event) as $img)
                                        <img src="{{ asset('storage/' . $img) }}" class="w-20 h-20 object-cover rounded shadow" alt="Image galerie">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Mettre à jour
                        </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
