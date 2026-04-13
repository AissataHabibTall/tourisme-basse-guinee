<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Liste des Circuits Touristiques
        </h2>
    </x-slot>

    @auth
        @if(Auth::user()->role === 'admin')
            <div class="py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Circuits Touristiques</h2>
                    <a href="{{ route('admin.circuits.create') }}"
                       class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition">
                        + Ajouter un Circuit
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse($circuits as $circuit)
                        <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                            <div class="h-48 overflow-hidden">
                                @if($circuit->image)
                                    <img src="{{ asset('storage/' . $circuit->image) }}" alt="Image du circuit {{ $circuit->nom }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gray-200 text-gray-500" role="img" aria-label="Aucune image disponible">
                                        Aucune image
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $circuit->nom }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($circuit->description, 80) }}</p>
                                <div class="flex justify-between items-center text-sm text-gray-700">
                                    <span class="text-green-600 font-bold">{{ number_format($circuit->prix, 2) }} €</span>
                                </div>
                                <div class="mt-2">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-semibold
                                        {{ $circuit->statut == 'actif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($circuit->statut) }}
                                    </span>
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <a href="{{ route('admin.circuits.edit', $circuit->id) }}"
                                       class="text-yellow-600 hover:text-yellow-800 font-medium text-sm">Modifier</a>

                                    <form action="{{ route('admin.circuits.destroy', $circuit->id) }}" method="POST"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce circuit ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-800 font-medium text-sm"
                                                aria-label="Supprimer le circuit {{ $circuit->nom }}">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500">
                            Aucun circuit disponible pour le moment.
                        </div>
                    @endforelse
                </div>
            </div>
        @else
            <div class="py-10 text-center text-gray-500">
                <h3>Vous n'avez pas accès à cette page.</h3>
            </div>
        @endif
    @endauth

    @guest
        <div class="py-10 text-center text-gray-500">
            <h3>Veuillez vous connecter pour accéder à cette page.</h3>
        </div>
    @endguest
</x-app-layout>
