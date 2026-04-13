<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
                Liste des utilisateurs
            </h2>
            <a href="{{ route('admin.utilisateurs.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                + Ajouter un utilisateur
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ route('admin.utilisateurs.index') }}" class="mb-4">
            <div class="flex justify-end gap-2">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Rechercher par nom, email ou rôle"
                       class="w-full max-w-md px-4 py-2 border rounded shadow-sm focus:ring focus:ring-indigo-300">

                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Rechercher
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white rounded-4 w-full">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($utilisateurs as $utilisateur)
                        <tr>
                            <td>{{ $utilisateur->id }}</td>
                            <td>{{ $utilisateur->nom }}</td>
                            <td>{{ $utilisateur->email }}</td>
                            <td>{{ ucfirst($utilisateur->role) }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('admin.utilisateurs.edit', $utilisateur->id) }}"
                                   class="btn btn-sm btn-warning">Modifier</a>
                                <form action="{{ route('admin.utilisateurs.destroy', $utilisateur->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucun utilisateur trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination style lieux / réservations --}}
        
        <div class="mt-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 text-center">

            <div class="flex justify-center gap-4">
                @if ($utilisateurs->currentPage() > 1)
                    <form method="GET" action="{{ route('admin.utilisateurs.index') }}">
                        <input type="hidden" name="page" value="{{ $utilisateurs->currentPage() - 1 }}">
                        <button type="submit"
                                class="flex items-center bg-gray-300 hover:bg-gray-400 text-gray-700 font-semibold px-4 py-2 rounded-md transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.293 4.293a1 1 0 010 1.414L8.414 9.586H16a1 1 0 110 2H8.414l3.879 3.879a1 1 0 11-1.414 1.414l-5.586-5.586a1 1 0 010-1.414l5.586-5.586a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Précédent
                        </button>
                    </form>
                @endif

                @if ($utilisateurs->hasMorePages())
                    <form method="GET" action="{{ route('admin.utilisateurs.index') }}">
                        <input type="hidden" name="page" value="{{ $utilisateurs->currentPage() + 1 }}">
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

            <form method="GET" action="{{ route('admin.utilisateurs.index') }}" class="flex justify-center items-center gap-2">
                <label for="pageNumber" class="text-sm text-gray-600">Aller à la page :</label>
                <input type="number" min="1" max="{{ $utilisateurs->lastPage() }}" name="page" id="pageNumber"
                       class="w-20 px-2 py-1 border border-gray-300 rounded-md text-center"
                       placeholder="{{ $utilisateurs->currentPage() }}">
                <button class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800">OK</button>
            </form>

        </div>
        
    </div>
</x-app-layout>
