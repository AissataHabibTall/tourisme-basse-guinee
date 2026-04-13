<!-- create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Faire une réservation
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-10">
        <form method="POST" action="{{ route('reservations.store') }}">
            @csrf

            <div class="mb-4">
                <label for="element_type" class="block font-medium">Type d'élément</label>
                <select name="element_type" id="element_type" class="w-full border rounded px-3 py-2">
                    <option value="">-- Choisir --</option>
                    <option value="hebergement">Hébergement</option>
                    <option value="guide">Guide</option>
                    <option value="lieu">Lieu</option>
                    <option value="circuit">Circuit</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="element_id" class="block font-medium">ID de l'élément</label>
                <input type="number" name="element_id" id="element_id" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="date_debut" class="block font-medium">Date de début</label>
                <input type="date" name="date_debut" id="date_debut" class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label for="date_fin" class="block font-medium">Date de fin</label>
                <input type="date" name="date_fin" id="date_fin" class="w-full border rounded px-3 py-2">
            </div>

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Réserver</button>
        </form>
    </div>
</x-app-layout>
