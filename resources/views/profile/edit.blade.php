<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-2xl mx-auto px-4">
            <div class="overflow-hidden shadow rounded-lg p-6 bg-white dark:bg-gray-800">

                @php
                    $initiales = strtoupper(substr($utilisateur->nom, 0, 1));
                    $cheminPhoto = 'photos_profil/' . $utilisateur->photo;
                    $photoExiste = $utilisateur->photo && \Illuminate\Support\Facades\Storage::disk('public')->exists($cheminPhoto);
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Colonne Photo --}}
                    <div class="flex flex-col items-center text-center">
                        @if ($photoExiste)
                            <div class="w-32 h-32 rounded-full overflow-hidden shadow mb-3">
                                <img src="{{ asset('storage/' . $cheminPhoto) }}?v={{ time() }}"
                                     alt="Photo de profil"
                                     class="object-cover w-full h-full">
                            </div>
                        @else
                            <div class="w-32 h-32 rounded-full bg-blue-600 text-white flex items-center justify-center text-3xl font-bold shadow mb-3">
                                {{ $initiales }}
                            </div>
                        @endif

                        <div class="mb-2">
                            <p class="text-md font-semibold text-gray-800 dark:text-white">{{ $utilisateur->nom }}</p>
                            <p class="text-sm text-gray-500">{{ $utilisateur->email }}</p>
                            <p class="text-sm text-gray-500 capitalize">Rôle : {{ $utilisateur->role }}</p>
                        </div>

                        {{-- Formulaire mise à jour photo --}}
                        <form method="POST" action="{{ route('profile.photo.update') }}" enctype="multipart/form-data" class="w-full">
                            @csrf
                            @method('PUT')
                            <label class="block text-sm text-gray-600 mb-1 text-left">Changer la photo</label>
                            <input type="file" name="photo"
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-700 file:bg-blue-600 file:text-white file:px-3 file:py-1 file:rounded-lg file:border-0 hover:file:bg-blue-700 mb-2">
                            @error('photo')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm px-3 py-2 rounded mb-2">
                                Mettre à jour
                            </button>
                        </form>

                        {{-- Formulaire suppression photo --}}
                        @if ($photoExiste)
                            <form method="POST" action="{{ route('profile.photo.delete') }}" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-2 rounded">
                                    Supprimer la photo
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Colonne Informations --}}
                    <div class="md:col-span-2 space-y-4">
                        {{-- Mise à jour des infos du profil --}}
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded shadow-sm">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        {{-- Section mise à jour du mot de passe --}}
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Changer le mot de passe</h3>

            <form method="POST" action="{{ route('profile.updatePassword') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="mot_de_passe_actuel" class="block font-medium text-gray-700 dark:text-gray-200">Mot de passe actuel</label>
                    <input type="password" id="mot_de_passe_actuel" name="mot_de_passe_actuel"
                           class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
                    @error('mot_de_passe_actuel')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="mot_de_passe" class="block font-medium text-gray-700 dark:text-gray-200">Nouveau mot de passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe"
                           class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
                    @error('mot_de_passe')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="mot_de_passe_confirmation" class="block font-medium text-gray-700 dark:text-gray-200">Confirmer le mot de passe</label>
                    <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation"
                           class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm">
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                        Mettre à jour le mot de passe
                    </button>
                </div>
            </form>
        </div>

                        {{-- Suppression du compte --}}
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded shadow-sm">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
