<?php

namespace App\Exports;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UtilisateursExport;


class ReservationsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Reservation::with('utilisateur', 'element')->get()->map(function ($reservation) {
            $type = class_basename($reservation->element_type); // Exemple: 'Hebergement', 'GuideTouristique'
            $nomElement = $reservation->element->nom ?? 'N/A';

            return [
                'ID' => $reservation->id,
                'Utilisateur' => $reservation->utilisateur->nom ?? 'N/A',
                'Type Réservation' => $type,
                'Nom Élément Réservé' => $nomElement,
                'Date Début' => $reservation->date_debut,
                'Date Fin' => $reservation->date_fin,
                'Statut' => ucfirst($reservation->statut), // corrigé ici (statut au lieu de status)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Utilisateur',
            'Type Réservation',
            'Nom Élément Réservé',
            'Date Début',
            'Date Fin',
            'Statut',
        ];
    }
}
