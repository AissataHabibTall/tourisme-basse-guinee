<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Mes Réservations (Guide)
        </h2>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white rounded-4">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Nom</th>
                        <th>Date début</th>
                        <th>Date fin</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $reservation)
                        <tr>
                            <td>{{ $reservation->id }}</td>
                            <td>{{ ucfirst($reservation->element_type) }}</td>
                            <td>{{ $reservation->element->nom ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge 
                                    @if($reservation->statut == 'confirmée') bg-success 
                                    @elseif($reservation->statut == 'en_attente') bg-warning text-dark 
                                    @else bg-danger 
                                    @endif">
                                    {{ ucfirst($reservation->statut) }}
                                </span>
                            </td>
                            <td>
                                @if($reservation->statut !== 'annulée')
                                    <!-- Exemple : bouton "Marquer comme terminé" pour guide -->
                                    <form action="{{ route('reservations.marquerTermine', $reservation->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Confirmer que cette réservation est terminée ?')">
                                            Terminé
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Aucune réservation trouvée.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
