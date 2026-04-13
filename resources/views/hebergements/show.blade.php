<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Détails de l'Hébergement
            </h2>
            <a href="{{ route('hebergements.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{ lightboxOpen: false, lightboxImage: '' }">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden p-6">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Image principale --}}
                @if ($hebergement->image_url && Storage::disk('public')->exists($hebergement->image_url))
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $hebergement->image_url) }}"
                             alt="Image de l'hébergement {{ $hebergement->nom }}"
                             class="rounded w-full h-64 object-cover shadow">
                    </div>
                @else
                    <div class="md:w-1/3 bg-gray-300 flex items-center justify-center h-64 text-gray-500 rounded">
                        Aucune image disponible
                    </div>
                @endif

                {{-- Détails --}}
                <div class="md:w-2/3">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">{{ $hebergement->nom }}</h1>

                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Type :</span><br>
                        {{ $hebergement->type }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300 mb-4">
                        <div><strong>Adresse :</strong> {{ $hebergement->adresse }}</div>
                        <div><strong>Prix par nuit :</strong> {{ number_format($hebergement->prixParNuit, 2, ',', ' ') }} GNF</div>
                        <div><strong>Contact :</strong> {{ $hebergement->contact }}</div>
                        <div><strong>Note Moyenne :</strong> {{ $hebergement->noteMoyenne ?? 'Non noté' }}</div>
                        <div>
                            <strong>Disponibilité :</strong> 
                            <span class="{{ $hebergement->disponibilite ? 'text-green-600' : 'text-red-600' }}">
                                {{ $hebergement->disponibilite ? 'Disponible' : 'Indisponible' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Galerie d'images --}}
            <div class="mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Galerie d'images</h2>

                @if (!empty($hebergement->galerie_images_hebergement) && count($hebergement->galerie_images_hebergement))
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                        @foreach ($hebergement->galerie_images_hebergement as $image)
                            @if (Storage::disk('public')->exists($image))
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="rounded-lg object-cover w-full h-28 cursor-pointer hover:opacity-80 transition"
                                     @click="lightboxOpen = true; lightboxImage = '{{ asset('storage/' . $image) }}'"
                                     alt="Image de l'hébergement {{ $hebergement->nom }}">
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Aucune image dans la galerie.</p>
                @endif
            </div>

            {{-- Formulaire de réservation (uniquement si hébergement disponible) --}}
            @if($hebergement->disponibilite)
                <div class="mt-10 border-t pt-6">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Faire une réservation</h4>

                    @guest
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            Veuillez <a href="{{ route('login') }}" class="text-blue-500 underline">vous connecter</a> pour réserver cet hébergement.
                        </div>
                    @endguest

                    @auth
                        {{-- Affichage des messages succès --}}
                        @if (session('success'))
                            <div class="text-green-600 mb-3">{{ session('success') }}</div>
                        @endif

                        {{-- Affichage des erreurs de validation --}}
                        @if ($errors->any())
                            <div class="text-red-600 mb-3">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('reservations.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="element_type" value="hebergement">
                            <input type="hidden" name="element_id" value="{{ $hebergement->id }}">

                            <div>
                                <label for="date_debut" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date d'arrivée</label>
                                <input type="date" name="date_debut" id="date_debut"
                                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white"
                                       value="{{ old('date_debut') }}" required>
                            </div>

                            <div>
                                <label for="date_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de départ</label>
                                <input type="date" name="date_fin" id="date_fin"
                                       class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white"
                                       value="{{ old('date_fin') }}" required>
                            </div>

                            <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                                Réserver
                            </button>
                        </form>
                    @endauth
                </div>
            @else
                <p class="text-red-600 mt-6">Cet hébergement n'est pas disponible actuellement.</p>
            @endif
        </div>

        {{-- Lightbox --}}
        <div x-show="lightboxOpen"
             x-transition
             class="fixed inset-0 bg-black bg-opacity-80 z-50 flex items-center justify-center p-4"
             @click.self="lightboxOpen = false">
            <img :src="lightboxImage" class="max-h-full max-w-full rounded shadow-lg" alt="Image agrandie">
            <button @click="lightboxOpen = false"
                    class="absolute top-4 right-4 text-white text-3xl font-bold" aria-label="Fermer">&times;</button>
        </div>
    </div>
</x-app-layout>
