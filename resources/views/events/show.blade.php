<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Détails de l'Événement
            </h2>
            <a href="{{ route('events.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8" x-data="{ lightboxOpen: false, lightboxImage: '' }">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden p-6">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- Image principale --}}
                @if ($event->image && Storage::disk('public')->exists($event->image))
                    <div class="md:w-1/3">
                        <img src="{{ asset('storage/' . $event->image) }}"
                             alt="Image de l'événement {{ $event->titre }}"
                             class="rounded w-full h-64 object-cover shadow">
                    </div>
                @else
                    <div class="md:w-1/3 bg-gray-300 flex items-center justify-center h-64 text-gray-500 rounded">
                        Aucune image disponible
                    </div>
                @endif

                {{-- Détails --}}
                <div class="md:w-2/3">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">{{ $event->titre }}</h1>

                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        <span class="font-semibold">Description :</span><br>
                        {{ $event->description }}
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300 mb-4">
                        <div><strong>Lieu :</strong> {{ $event->lieu }}</div>
                        <div><strong>Prix :</strong> {{ number_format($event->prix, 2) }} GNF</div>
                        <div><strong>Date début :</strong> {{ \Carbon\Carbon::parse($event->date_debut)->format('d/m/Y') }}</div>
                        <div><strong>Date fin :</strong> {{ \Carbon\Carbon::parse($event->date_fin)->format('d/m/Y') }}</div>
                    </div>
                </div>
            </div>

            {{-- Galerie d'images --}}
            <div class="mt-10">
                <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Galerie d'images</h2>

                @if (!empty($event->galerie_images_event) && is_array($event->galerie_images_event) && count($event->galerie_images_event))
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-4">
                        @foreach ($event->galerie_images_event as $image)
                            @if (Storage::disk('public')->exists($image))
                                <img src="{{ asset('storage/' . $image) }}"
                                     class="rounded-lg object-cover w-full h-28 cursor-pointer hover:opacity-80 transition"
                                     @click="lightboxOpen = true; lightboxImage = '{{ asset('storage/' . $image) }}'"
                                     alt="Image de l'événement {{ $event->titre }}">
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Aucune image dans la galerie.</p>
                @endif
            </div>
        </div>

        {{-- Lightbox --}}
        <div x-show="lightboxOpen"
             x-transition
             class="fixed inset-0 bg-black bg-opacity-80 z-50 flex items-center justify-center p-4"
             @click.self="lightboxOpen = false">
            <img :src="lightboxImage" class="max-h-full max-w-full rounded shadow-lg">
            <button @click="lightboxOpen = false"
                    class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
        </div>
    </div>
</x-app-layout>
