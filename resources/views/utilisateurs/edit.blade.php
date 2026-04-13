<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier l'utilisateur
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Modifier l'utilisateur : {{ $utilisateur->nom }}
                </h2>

                <form action="{{ route('admin.utilisateurs.update', $utilisateur->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom', $utilisateur->nom) }}"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   required>
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $utilisateur->email) }}"
                                   class="form-control @error('email') is-invalid @enderror"
                                   required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Mot de passe --}}
                        <div class="col-md-6">
                            <label for="mot_de_passe" class="form-label text-gray-700 dark:text-gray-300">Mot de passe</label>
                            <input type="password"
                                   id="mot_de_passe"
                                   name="mot_de_passe"
                                   class="form-control @error('mot_de_passe') is-invalid @enderror">
                            @error('mot_de_passe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-gray-600 dark:text-gray-400">Laissez vide si vous ne souhaitez pas changer le mot de passe.</small>
                        </div>

                        {{-- Rôle --}}
                        <div class="col-md-6">
                            <label for="role" class="form-label text-gray-700 dark:text-gray-300">Rôle</label>
                            <select id="role"
                                    name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required>
                                <option value="utilisateur" {{ old('role', $utilisateur->role) == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
                                <option value="admin" {{ old('role', $utilisateur->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="guide" {{ old('role', $utilisateur->role) == 'guide' ? 'selected' : '' }}>Guide</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Mettre à jour l'utilisateur
                        </button>
                        <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary ml-3 px-5 py-2">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
