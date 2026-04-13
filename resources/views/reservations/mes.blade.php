<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Mes Réservations
        </h2>
    </x-slot>

    <div class="py-6 px-4">
        @if($reservations->isEmpty())
            <p class="text-gray-600">Aucune réservation trouvée.</p>
        @else
            <div class="space-y-4">
                @foreach($reservations as $reservation)
                    <div class="p-4 border rounded shadow">
                        <p><strong>Réservé par :</strong> {{ $reservation->utilisateur->nom ?? 'Inconnu' }}</p>
                        <p><strong>Date :</strong> {{ $reservation->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Statut :</strong> {{ ucfirst($reservation->statut) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
