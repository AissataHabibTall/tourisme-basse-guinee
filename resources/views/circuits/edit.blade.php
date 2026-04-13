<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Modifier un Circuit Touristique
        </h2>
    </x-slot>

    <div class="container mt-5">
        <div class="card shadow-sm rounded-4 p-4 bg-white">
            <h2 class="card-title mb-4 text-center text-2xl font-bold text-gray-800">Formulaire de Circuit Touristique</h2>
            <form action="{{ route('admin.circuits.update', $circuit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nom -->
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" id="nom" value="{{ old('nom', $circuit->nom) }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="4" required>{{ old('description', $circuit->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Prix -->
                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="number" step="0.01" class="form-control @error('prix') is-invalid @enderror" name="prix" id="prix" value="{{ old('prix', $circuit->prix) }}" required>
                    @error('prix')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date de début -->
                <div class="mb-3">
                    <label for="dateDebut" class="form-label">Date de début</label>
                    <input type="date" class="form-control @error('dateDebut') is-invalid @enderror" name="dateDebut" id="dateDebut" value="{{ old('dateDebut', $circuit->dateDebut) }}" required>
                    @error('dateDebut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div class="mb-3">
                    <label for="dateFin" class="form-label">Date de fin</label>
                    <input type="date" class="form-control @error('dateFin') is-invalid @enderror" name="dateFin" id="dateFin" value="{{ old('dateFin', $circuit->dateFin) }}" required>
                    @error('dateFin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Statut -->
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select @error('statut') is-invalid @enderror" name="statut" id="statut" required>
                        <option value="actif" {{ old('statut', $circuit->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('statut', $circuit->statut) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('statut')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-2">
                        @if ($circuit->image)
                            <img src="{{ asset('storage/' . $circuit->image) }}" alt="Image du circuit" class="img-fluid rounded-3" style="max-width: 150px;">
                        @else
                            <p>Aucune image actuelle</p>
                        @endif
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </form>
        </div>
    </div>

    <script>
        const inputImage = document.getElementById('image');
        const previewImg = document.querySelector('.img-fluid');

        inputImage.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(previewImg) {
                        previewImg.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('img-fluid', 'rounded-3');
                        img.style.maxWidth = '150px';
                        inputImage.parentNode.appendChild(img);
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
