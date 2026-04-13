<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Ajouter un Circuit Touristique
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow-sm rounded-4 p-4 bg-white">
            <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800">Formulaire de Circuit Touristique</h2>
            <form action="{{ route('admin.circuits.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" name="prix" id="prix" value="{{ old('prix') }}" required>
                    @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date de début -->
                <div class="mb-3">
                    <label for="dateDebut" class="form-label">Date de début</label>
                    <input type="date" class="form-control @error('dateDebut') is-invalid @enderror" name="dateDebut" id="dateDebut" value="{{ old('dateDebut') }}" required>
                    @error('dateDebut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div class="mb-3">
                    <label for="dateFin" class="form-label">Date de fin</label>
                    <input type="date" class="form-control @error('dateFin') is-invalid @enderror" name="dateFin" id="dateFin" value="{{ old('dateFin') }}" required>
                    @error('dateFin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                        <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image" required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </form>
        </div>
    </div>
</x-app-layout>
