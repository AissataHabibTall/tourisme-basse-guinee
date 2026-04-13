<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Liste des Avis
        </h2>
    </x-slot>

    @auth
        @if(Auth::user()->role === 'admin')
            <div class="container mt-5">
                <div class="card shadow-sm rounded-4 p-4 bg-white dark:bg-gray-800">
                    <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">Tous les Avis</h2>

                    <div class="text-end mb-4">
                        <a href="{{ route('admin.avis.create') }}" class="btn btn-success">Ajouter un Avis</a>
                    </div>

                    @if(session('success'))
                        <div class="mb-3 text-green-600">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped text-sm">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th>ID</th>
                                    <th>Utilisateur</th>
                                    <th>Note</th>
                                    <th>Commentaire</th>
                                    <th>Cible</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($avis as $av)
                                    <tr>
                                        <td>{{ $av->id }}</td>
                                        <td>{{ $av->utilisateur->nom ?? 'N/A' }}</td>
                                        <td>{{ $av->note }}</td>
                                        <td>{{ $av->commentaire }}</td>
                                        <td>{{ $av->cible_type }}</td>
                                        <td>{{ $av->date }}</td>
                                        <td class="d-flex gap-1">
                                            <a href="{{ route('admin.avis.edit', $av->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                                            <form action="{{ route('admin.avis.destroy', $av->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @else
            <div class="py-10 text-center text-gray-500">
                <h3>⛔ Vous n'avez pas accès à cette page.</h3>
            </div>
        @endif
    @endauth

    @guest
        <div class="py-10 text-center text-gray-500">
            <h3>🔒 Veuillez vous connecter pour accéder à cette page.</h3>
        </div>
    @endguest
</x-app-layout>
