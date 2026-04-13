<x-guest-layout>  
    <div class="max-w-2xl bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col md:flex-row mx-auto">

        <!-- Côté image -->
        <div class="md:w-1/2 hidden md:block relative">
            <img 
                src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" 
                alt="Tourisme Guinée" 
                class="h-full w-full object-cover"
            />
            <div class="absolute inset-0 bg-black bg-opacity-30 flex flex-col justify-center items-center p-8">
                <h2 class="text-white text-3xl font-extrabold mb-4 drop-shadow-lg">Rejoignez-nous !</h2>
                <p class="text-white text-md font-light drop-shadow-md">
                    Découvrez la Guinée autrement. Inscrivez-vous et partez à l'aventure !
                </p>
            </div>
        </div>

        <!-- Côté formulaire -->
        <div class="w-full md:w-1/2 p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Créer un compte</h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nom -->
                <div>
                    <x-input-label for="nom" :value="__('Nom')" />
                    <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required autofocus />
                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <x-input-label for="password" :value="__('Mot de passe')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmation du mot de passe -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmation du mot de passe')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <a class="text-sm text-green-600 hover:underline" href="{{ route('login') }}">
                        {{ __('Déjà inscrit ?') }}
                    </a>

                    <x-primary-button>
                        {{ __('S\'inscrire') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div> 
</x-guest-layout>  
