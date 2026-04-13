<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Réservations
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

         @can('view-admin-section')
            @include('reservations.partials.admin-table', ['reservations' => $reservations])
        @elsecan('view-guide-section')
            @include('reservations.partials.guide_table', ['reservations' => $reservations])
        @else
            @include('reservations.partials.utilisateur-table', ['reservations' => $reservations])
        @endcan
    </div>
</x-app-layout>
