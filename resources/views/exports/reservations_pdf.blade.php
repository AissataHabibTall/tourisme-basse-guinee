<!DOCTYPE html>
<html>
<head>
    <title>Liste des Réservations</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
        }
        th {
            background-color: #f8f8f8;
        }
    </style>
</head>
<body>
    <h2>Liste des Réservations</h2>

    @if(Auth::user()->role !== 'admin')
        <p style="color: red;">Accès non autorisé. Seul l'administrateur peut consulter cette page.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Type</th>
                    <th>Nom de l'Élément</th>
                    <th>Date Début</th>
                    <th>Date Fin</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->utilisateur->nom ?? 'N/A' }}</td>
                        <td>{{ ucfirst($reservation->element_type) }}</td>

                        <td>
                            @php
                                $element = $reservation->element;
                            @endphp
                            {{ $element->nom ?? 'N/A' }}
                        </td>
                       <td>{{ \Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}</td>

                        <td>
                                <span class="badge 
                                    @if($reservation->statut == 'confirmée') bg-success 
                                    @elseif($reservation->statut == 'en_attente') bg-warning text-dark 
                                    @else bg-danger 
                                    @endif">
                                    {{ ucfirst($reservation->statut) }}
                                </span>
                            </td>
                        
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Aucune réservation trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif
</body>
</html>
