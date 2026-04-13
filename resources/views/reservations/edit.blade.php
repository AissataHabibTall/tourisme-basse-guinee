<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier la réservation
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">
        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.reservations.update', $reservation->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Type d'élément -->
            <div class="mb-4">
                <label for="element_type" class="block text-sm font-medium text-gray-700">Type de réservation</label>
                <select name="element_type" id="element_type"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                        onchange="afficherOptions()" required>
                    <option value="">-- Choisir un type --</option>
                    <option value="hebergement" {{ $reservation->element_type == 'hebergement' ? 'selected' : '' }}>Hébergement</option>
                    <option value="guide" {{ $reservation->element_type == 'guide' ? 'selected' : '' }}>Guide touristique</option>
                    <option value="lieu" {{ $reservation->element_type == 'lieu' ? 'selected' : '' }}>Lieu touristique</option>
                    <option value="circuit" {{ $reservation->element_type == 'circuit' ? 'selected' : '' }}>Circuit touristique</option>
                </select>
            </div>

            <!-- Élément lié -->
            <div class="mb-4" id="element_selection">
                <!-- Dynamique avec JS -->
            </div>

            <!-- Dates -->
            <div class="mb-4">
                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date de début</label>
                <input type="date" name="date_debut" id="date_debut"
                       value="{{ $reservation->date_debut }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            <div class="mb-4">
                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin"
                       value="{{ $reservation->date_fin }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
            </div>

            @if(Auth::user()->role === 'admin')
                <!-- Statut -->
                <div class="mb-4">
                    <label for="statut" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="statut" id="statut"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="pending" {{ $reservation->statut === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="confirmed" {{ $reservation->statut === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                        <option value="cancelled" {{ $reservation->statut === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                    </select>
                </div>
            @endif

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    Mettre à jour
                </button>
            </div>
        </form>

        @if(Auth::user()->role !== 'admin' && $reservation->statut === 'pending')
            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="mt-4"
                  onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?')">
                @csrf
                @method('DELETE')
                <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Annuler la réservation
                </button>
            </form>
        @endif
    </div>

    <!-- JS pour afficher les options dynamiques -->
    <script>
        const options = {
            hebergement: @json(App\Models\Hebergement::all()),
            guide: @json(\App\Models\GuideTouristique::all()),
            lieu: @json(\App\Models\LieuTouristique::all()),
            circuit: @json(\App\Models\CircuitTouristique::all()),
        };

        function afficherOptions() {
            const type = document.getElementById('element_type').value;
            const selectZone = document.getElementById('element_selection');
            const elements = options[type] || [];

            if (!type || elements.length === 0) {
                selectZone.innerHTML = '';
                return;
            }

            let html = `<label for="element_id" class="block text-sm font-medium text-gray-700 mt-4">Sélectionner un ${type}</label>`;
            html += `<select name="element_id" id="element_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>`;
            html += `<option value="">-- Choisir --</option>`;

            elements.forEach(item => {
                const nom = item.nom || item.titre || 'Sans nom';
                const selected = item.id === {{ $reservation->element_id }} ? 'selected' : '';
                html += `<option value="${item.id}" ${selected}>${nom}</option>`;
            });

            html += `</select>`;
            selectZone.innerHTML = html;
        }

        // Initialiser après chargement
        document.addEventListener('DOMContentLoaded', afficherOptions);
    </script>
</x-app-layout>
