<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Liste des restaurants
            </h2>

            @can('view-admin-section')
                <a href="{{ route('admin.restaurants.create') }}"
                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                    Ajouter un restaurant
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">

        {{-- Barre de recherche --}}
        <form method="GET" action="{{ route('restaurants.index') }}" class="mb-6 flex justify-end gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher par nom, adresse ou spécialité..."
                   class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 w-64" />
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                Rechercher
            </button>
        </form>

        {{-- Message succès --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($restaurants as $restaurant)
                <div class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-lg transition duration-300">

                    @if($restaurant->image_url)
                        <img src="{{ asset('storage/' . $restaurant->image_url) }}"
                             alt="Image principale de {{ $restaurant->nom }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="flex items-center justify-center h-48 bg-gray-200 text-gray-500">
                            Aucune image
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $restaurant->nom }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $restaurant->adresse }}</p>

                        <div class="mt-4 flex justify-between items-center">
                            <a href="{{ route('restaurants.show', $restaurant->id) }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                Voir détails
                            </a>

                            @can('view-admin-section')
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.restaurants.edit', $restaurant->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Modifier
                                    </a>
                                    <form action="{{ route('admin.restaurants.destroy', $restaurant->id) }}" method="POST"
                                          onsubmit="return confirm('Supprimer ce restaurant ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500">
                    Aucun restaurant trouvé.
                </div>
            @endforelse
        </div>

        {{-- Pagination identique aux lieux --}}
        <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 text-center">

            <div class="flex justify-center gap-4">
                @if ($restaurants->currentPage() > 1)
                    <form method="GET" action="{{ route('restaurants.index') }}">
                        <input type="hidden" name="page" value="{{ $restaurants->currentPage() - 1 }}">
                        <button type="submit"
                                class="flex items-center bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold px-4 py-2 rounded-md transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 4.293a1 1 0 010 1.414L8.414 9.586H16a1 1 0 110 2H8.414l3.879 3.879a1 1 0 11-1.414 1.414l-5.586-5.586a1 1 0 010-1.414l5.586-5.586a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Précédent
                        </button>
                    </form>
                @endif

                @if ($restaurants->hasMorePages())
                    <form method="GET" action="{{ route('restaurants.index') }}">
                        <input type="hidden" name="page" value="{{ $restaurants->currentPage() + 1 }}">
                        <button type="submit"
                                class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-md transition">
                            Voir plus
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.707 15.707a1 1 0 010-1.414L11.586 11H4a1 1 0 110-2h7.586L7.707 5.707a1 1 0 011.414-1.414l5.586 5.586a1 1 0 010 1.414l-5.586 5.586a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </form>
                @endif
            </div>

            <form method="GET" action="{{ route('restaurants.index') }}" class="flex justify-center items-center gap-2">
                <label for="pageNumber" class="text-sm text-gray-600">Aller à la page :</label>
                <input type="number" min="1" max="{{ $restaurants->lastPage() }}" name="page" id="pageNumber"
                       class="w-20 px-2 py-1 border border-gray-300 rounded-md text-center"
                       placeholder="{{ $restaurants->currentPage() }}">
                <button class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800">OK</button>
            </form>

        </div>
    </div>
</x-app-layout>
