<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Mes Réservations (Guide)
        </h2>
    </x-slot>
    <table class="table">
        <thead>
            <tr>
                <th>Nom de l'utilisateur</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>{{ $reservation->utilisateur->nom }}</td>
                    <td>{{ $reservation->created_at->format('d/m/Y') }}</td>
                    <td>{{ $reservation->statut }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucune réservation trouvée.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-app-layout>