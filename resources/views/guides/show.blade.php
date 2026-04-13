<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails du guide : {{ $guide->nom }}
            </h2>
            <a href="{{ route('guides.index') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition">
                ← Retour à la liste
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            {{-- Messages de succès --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Messages d'erreur --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Informations du guide --}}
            <div class="flex flex-col md:flex-row gap-4">
                @if($guide->image_url)
                    <div class="md:w-1/3">
                        <img src="{{ $guide->image_url }}" alt="Image du guide" class="rounded w-full">
                    </div>
                @endif

                <div class="md:w-2/3">
                    <h3 class="text-2xl font-bold">{{ $guide->nom }}</h3>
                    <p><strong>Langues parlées :</strong> {{ $guide->languesParlees }}</p>
                    <p><strong>Zone couverte :</strong> {{ $guide->zoneCouverte }}</p>
                    <p><strong>Expérience :</strong> {{ $guide->experience }}</p>
                    <p><strong>Tarif journalier :</strong> {{ number_format($guide->tarifJournalier, 2) }} GNF</p>
                    <p><strong>Contact :</strong> {{ $guide->contact }}</p>
                    <p>
                        <strong>Disponibilité :</strong>
                        <span class="text-{{ $guide->disponibilite ? 'green' : 'red' }}-600">
                            {{ $guide->disponibilite ? 'Disponible' : 'Non disponible' }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Réservation --}}
            @if($guide->disponibilite)
                <div class="mt-6">
                    <h4 class="text-xl font-semibold mb-4">Réserver ce guide</h4>

                    @guest
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                            Veuillez <a href="{{ route('login') }}" class="text-blue-500 underline">vous connecter</a> pour réserver ce guide.
                        </div>
                    @endguest

                    @auth
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="element_type" value="guide">
                            <input type="hidden" name="element_id" value="{{ $guide->id }}">

                            <div class="mb-4">
                                <label for="date_debut" class="block font-medium">Date de début</label>
                                <input type="date" name="date_debut" class="form-input w-full" required>
                            </div>

                            <div class="mb-4">
                                <label for="date_fin" class="block font-medium">Date de fin</label>
                                <input type="date" name="date_fin" class="form-input w-full" required>
                            </div>

                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                                Réserver
                            </button>
                        </form>
                    @endauth
                </div>
            @else
                <p class="text-red-600 mt-6">Ce guide n'est pas disponible actuellement.</p>
            @endif
        </div>
    </div>
</x-app-layout>
