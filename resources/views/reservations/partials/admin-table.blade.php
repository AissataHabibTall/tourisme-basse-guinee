

    <div class="container mx-auto py-6">
        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 d-flex gap-2">
    <a href="{{ route('admin.reservations.export.pdf') }}" class="btn btn-success">📄 Exporter en PDF</a>
    <!--<a href="{{ route('admin.reservations.export.excel') }}" class="btn btn-success">📊 Exporter en Excel</a> -->
</div>

       {{-- Barre de recherche alignée à droite --}}
        <form method="GET" action="{{ route('admin.reservations.index') }}" class="mb-6 flex justify-end gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Rechercher un ..."
                   class="px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 w-64" />

            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                Rechercher
            </button>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white rounded-4">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Utilisateur</th>
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
                            <td>{{ $reservation->utilisateur->nom ?? 'N/A' }}</td>
                            <td>{{ ucfirst($reservation->element_type) }}</td>
                            <td>
                                @php
                                    $element = $reservation->element;
                                @endphp
                                {{ $element->nom ?? 'N/A' }}
                            </td>
                            <td>{{ $reservation->date_debut }}</td>
                            <td>{{ $reservation->date_fin }}</td>
                            <td>
                                <span class="badge 
                                    @if($reservation->statut == 'confirmée') bg-success 
                                    @elseif($reservation->statut == 'en_attente') bg-warning text-dark 
                                    @else bg-danger 
                                    @endif">
                                    {{ ucfirst($reservation->statut) }}
                                </span>
                            </td>
                            <td class="d-flex gap-2">
                                <form action="{{ route('admin.reservations.updateStatus', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="statut" class="form-select" onchange="this.form.submit()">
                                        <option value="en_attente" {{ $reservation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirmée" {{ $reservation->statut == 'confirmée' ? 'selected' : '' }}>Confirmée</option>
                                        <option value="annulée" {{ $reservation->statut == 'annulée' ? 'selected' : '' }}>Annulée</option>
                                    </select>
                                </form>

                                <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST"
                                    onsubmit="return confirm('Confirmer la suppression ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Aucune réservation</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination identique aux lieux --}}
        @if($reservations->lastPage() > 1)
        <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 text-center">

            <div class="flex justify-center gap-4">
                @if ($reservations->currentPage() > 1)
                    <form method="GET" action="{{ route('admin.reservations.index') }}">
                        <input type="hidden" name="page" value="{{ $reservations->currentPage() - 1 }}">
                        <button type="submit"
                                class="flex items-center bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold px-4 py-2 rounded-md transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 4.293a1 1 0 010 1.414L8.414 9.586H16a1 1 0 110 2H8.414l3.879 3.879a1 1 0 11-1.414 1.414l-5.586-5.586a1 1 0 010-1.414l5.586-5.586a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Précédent
                        </button>
                    </form>
                @endif

                @if ($reservations->hasMorePages())
                    <form method="GET" action="{{ route('admin.reservations.index') }}">
                        <input type="hidden" name="page" value="{{ $reservations->currentPage() + 1 }}">
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

            <form method="GET" action="{{ route('admin.reservations.index') }}" class="flex justify-center items-center gap-2">
                <label for="pageNumber" class="text-sm text-gray-600">Aller à la page :</label>
                <input type="number" min="1" max="{{ $reservations->lastPage() }}" name="page" id="pageNumber"
                       class="w-20 px-2 py-1 border border-gray-300 rounded-md text-center"
                       placeholder="{{ $reservations->currentPage() }}">
                <button class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800">OK</button>
            </form>

        </div>
        @endif
    </div>

