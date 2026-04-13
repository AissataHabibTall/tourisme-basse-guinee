<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un utilisateur
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="card shadow-lg rounded-4 p-4 bg-white dark:bg-gray-800">
                <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800 dark:text-white">
                    Nouveau utilisateur
                </h2>

                <form action="{{ route('admin.utilisateurs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        {{-- Nom --}}
                        <div class="col-md-6">
                            <label for="nom" class="form-label text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text"
                                   id="nom"
                                   name="nom"
                                   value="{{ old('nom') }}"
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
                                   value="{{ old('email') }}"
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
                                   class="form-control @error('mot_de_passe') is-invalid @enderror"
                                   required>
                            @error('mot_de_passe') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Confirmation mot de passe --}}
                        <div class="col-md-6">
                            <label for="mot_de_passe_confirmation" class="form-label text-gray-700 dark:text-gray-300">Confirmer le mot de passe</label>
                            <input type="password"
                                   id="mot_de_passe_confirmation"
                                   name="mot_de_passe_confirmation"
                                   class="form-control @error('mot_de_passe_confirmation') is-invalid @enderror"
                                   required>
                            @error('mot_de_passe_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Rôle --}}
                        <div class="col-md-6">
                            <label for="role" class="form-label text-gray-700 dark:text-gray-300">Rôle</label>
                            <select id="role"
                                    name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required>
                                <option value="utilisateur" {{ old('role') == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                <option value="guide" {{ old('role') == 'guide' ? 'selected' : '' }}>Guide</option>
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                                Ajouter un utilisateur
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
