<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">Statistique Administrateur</h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            {{-- Utilisateurs --}}
            <a href="{{ route('admin.utilisateurs.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-users text-4xl text-blue-600 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Utilisateurs</h3>
                <p class="text-3xl font-bold text-blue-600">{{ $totalUtilisateurs }}</p>
            </a>

            {{-- Lieux --}}
            <a href="{{ route('admin.lieux.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-map-marker-alt text-4xl text-green-600 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Lieux</h3>
                <p class="text-3xl font-bold text-green-600">{{ $totalLieux }}</p>
            </a>

            {{-- Réservations --}}
            <a href="{{ route('admin.reservations.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-book text-4xl text-indigo-600 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Réservations</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $totalReservations }}</p>
            </a>

            {{-- Événements --}}
            <a href="{{ route('admin.events.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-calendar-alt text-4xl text-yellow-500 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Événements</h3>
                <p class="text-3xl font-bold text-yellow-500">{{ $totalEvents }}</p>
            </a>

            {{-- Restaurants --}}
            <a href="{{ route('admin.restaurants.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-utensils text-4xl text-red-500 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Restaurants</h3>
                <p class="text-3xl font-bold text-red-500">{{ $totalRestaurants }}</p>
            </a>

            {{-- Guides --}}
            <a href="{{ route('admin.guides.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-user-tie text-4xl text-purple-500 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Guides</h3>
                <p class="text-3xl font-bold text-purple-500">{{ $totalGuides }}</p>
            </a>

            {{-- Circuits --}}
            <!--<a href="{{ route('admin.circuits.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-route text-4xl text-pink-500 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Circuits</h3>
                <p class="text-3xl font-bold text-pink-500">{{ $totalCircuits }}</p>
            </a>-->

            {{-- Hébergements --}}
            <a href="{{ route('admin.hebergements.index') }}"
               class="bg-white rounded-xl shadow p-6 text-center hover:shadow-lg transition block">
                <i class="fas fa-bed text-4xl text-teal-600 mb-2"></i>
                <h3 class="text-gray-700 text-lg font-semibold">Hébergements</h3>
                <p class="text-3xl font-bold text-teal-600">{{ $totalHebergements }}</p>
            </a>

        </div>
    </div>
</x-app-layout>
