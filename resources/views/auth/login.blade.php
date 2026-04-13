<x-guest-layout>
    <div class="max-w-2xl bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col md:flex-row mx-auto">

        <!-- Côté image -->
        <div class="md:w-1/2 hidden md:block relative">
            <img 
                src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" 
                alt="Connexion Tourisme Guinée" 
                class="h-full w-full object-cover"
            />
            <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center p-8">
                <h2 class="text-white text-3xl font-extrabold mb-4 drop-shadow-lg">Bienvenue !</h2>
                <p class="text-white text-md font-light drop-shadow-md">
                    Connectez-vous pour planifier votre prochaine aventure en Guinée.
                </p>
            </div>
        </div>

        <!-- Côté formulaire -->
        <div class="w-full md:w-1/2 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Se connecter</h1>

            <!-- Drapeau -->
            <div class="flex justify-center mb-6">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/ed/Flag_of_Guinea.svg" 
                     alt="Drapeau de la Guinée" 
                     class="w-12 h-auto rounded-sm shadow-md" />
            </div>

            <!-- Status de session -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Adresse Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <x-input-label for="mot_de_passe" :value="__('Mot de passe')" />
                    <x-text-input id="mot_de_passe" class="block mt-1 w-full" type="password" name="mot_de_passe" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('mot_de_passe')" class="mt-2" />
                </div>

                <!-- Se souvenir de moi + mot de passe oublié -->
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center text-sm text-gray-600">
                        <input type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                        <span class="ml-2">Se souvenir de moi</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-green-600 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Bouton -->
                <x-primary-button class="w-full justify-center">
                    {{ __('Se connecter') }}
                </x-primary-button>
            </form>

            <!-- Lien vers l'inscription -->
            <div class="mt-4 text-center text-sm text-gray-600">
                Pas encore inscrit ?
                <a href="{{ route('register') }}" class="text-green-600 hover:underline">
                    Créer un compte
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
