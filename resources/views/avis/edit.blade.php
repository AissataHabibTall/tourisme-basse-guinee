<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier l'Avis
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow-sm rounded-4 p-4 bg-white">
            <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800">Modifier l'Avis</h2>
            <form action="{{ route('admin.avis.update', $avis->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="utilisateur_id" class="form-label">Utilisateur</label>
                    <select class="form-select @error('utilisateur_id') is-invalid @enderror" name="utilisateur_id" id="utilisateur_id" required>
                        <option value="">-- Sélectionner --</option>
                        @foreach($utilisateurs as $utilisateur)
                            <option value="{{ $utilisateur->id }}" {{ $avis->utilisateur_id == $utilisateur->id ? 'selected' : '' }}>{{ $utilisateur->nom }}</option>
                        @endforeach
                    </select>
                    @error('utilisateur_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">Note</label>
                    <input type="number" class="form-control @error('note') is-invalid @enderror" name="note" id="note" value="{{ $avis->note }}" min="1" max="5" required>
                    @error('note')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="commentaire" class="form-label">Commentaire</label>
                    <textarea class="form-control @error('commentaire') is-invalid @enderror" name="commentaire" id="commentaire" rows="4" required>{{ $avis->commentaire }}</textarea>
                    @error('commentaire')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cible_type" class="form-label">Cible</label>
                    <select class="form-select @error('cible_type') is-invalid @enderror" name="cible_type" id="cible_type" required>
                        <option value="Lieu" {{ $avis->cible_type == 'Lieu' ? 'selected' : '' }}>Lieu Touristique</option>
                        <option value="Hebergement" {{ $avis->cible_type == 'Hebergement' ? 'selected' : '' }}>Hébergement</option>
                        <option value="Guide" {{ $avis->cible_type == 'Guide' ? 'selected' : '' }}>Guide Touristique</option>
                    </select>
                    @error('cible_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cible_id" class="form-label">ID de la Cible</label>
                    <input type="number" class="form-control @error('cible_id') is-invalid @enderror" name="cible_id" id="cible_id" value="{{ $avis->cible_id }}" required>
                    @error('cible_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="date" value="{{ $avis->date }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
