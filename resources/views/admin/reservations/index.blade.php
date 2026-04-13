<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Liste des Réservations
            </h2>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        {{-- ✅ Flash Message de succès --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2">Utilisateur</th>
                        <th class="px-4 py-2">Type Élément</th>
                        <th class="px-4 py-2">Nom Élément</th>
                        <th class="px-4 py-2">Date Début</th>
                        <th class="px-4 py-2">Date Fin</th>
                        <th class="px-4 py-2">Statut</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $reservation->id }}</td>
                            <td class="px-4 py-2">{{ $reservation->utilisateur->nom ?? 'Inconnu' }}</td>
                            <td class="px-4 py-2">
                                {{ class_basename($reservation->element_type) }}
                            </td>
                            <td class="px-4 py-2">
                                {{ optional($reservation->element)->nom ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">
                                {{-- ✅ Formulaire de changement de statut --}}
                                <form action="{{ route('admin.reservations.changerStatut', $reservation->id) }}" method="POST" class="d-inline-block me-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" onchange="this.form.submit()" class="form-select form-select-sm rounded text-sm">
                                        <option value="pending" {{ $reservation->statut == 'pending' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirmed" {{ $reservation->statut == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                        <option value="cancelled" {{ $reservation->statut == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.reservations.edit', $reservation->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Modifier
                                </a>
                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer cette réservation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-4">Aucune réservation trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
